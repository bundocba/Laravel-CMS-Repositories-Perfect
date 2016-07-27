/*! Responsive 1.0.6
 * 2014-2015 SpryMedia Ltd - datatables.net/license
 */

/**
 * @summary     Responsive
 * @description Responsive tables plug-in for DataTables
 * @version     1.0.6
 * @file        dataTables.responsive.js
 * @author      SpryMedia Ltd (www.sprymedia.co.uk)
 * @contact     www.sprymedia.co.uk/contact
 * @copyright   Copyright 2014-2015 SpryMedia Ltd.
 *
 * This source file is free software, available under the following license:
 *   MIT license - http://datatables.net/license/mit
 *
 * This source file is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the license files for details.
 *
 * For details please refer to: http://www.datatables.net
 */

(function(window, document, undefined) {


var factory = function( $, DataTable ) {
"use strict";

/**
 * Responsive is a plug-in for the DataTables library that makes use of
 * DataTables' ability to change the visibility of columns, changing the
 * visibility of columns so the displayed columns fit into the table container.
 * The end result is that complex tables will be dynamically adjusted to fit
 * into the viewport, be it on a desktop, tablet or mobile browser.
 *
 * Responsive for DataTables has two modes of operation, which can used
 * individually or combined:
 *
 * * Class name based control - columns assigned class names that match the
 *   breakpoint logic can be shown / hidden as required for each breakpoint.
 * * Automatic control - columns are automatically hidden when there is no
 *   room left to display them. Columns removed from the right.
 *
 * In additional to column visibility control, Responsive also has built into
 * options to use DataTables' child row display to show / hide the information
 * from the table that has been hidden. There are also two modes of operation
 * for this child row display:
 *
 * * Inline - when the control element that the user can use to show / hide
 *   child rows is displayed inside the first column of the table.
 * * Column - where a whole column is dedicated to be the show / hide control.
 *
 * Initialisation of Responsive is performed by:
 *
 * * Adding the class `responsive` or `dt-responsive` to the table. In this case
 *   Responsive will automatically be initialised with the default configuration
 *   options when the DataTable is created.
 * * Using the `responsive` option in the DataTables configuration options. This
 *   can also be used to specify the configuration options, or simply set to
 *   `true` to use the defaults.
 *
 *  @class
 *  @param {object} settings DataTables settings object for the host table
 *  @param {object} [opts] Configuration options
 *  @requires jQuery 1.7+
 *  @requires DataTables 1.10.1+
 *
 *  @example
 *      $('#example').DataTable( {
 *        responsive: true
 *      } );
 *    } );
 */
var Responsive = function ( settings, opts ) {
	// Sanity check that we are using DataTables 1.10 or newer
	if ( ! DataTable.versionCheck || ! DataTable.versionCheck( '1.10.1' ) ) {
		throw 'DataTables Responsive requires DataTables 1.10.1 or newer';
	}

	this.s = {
		dt: new DataTable.Api( settings ),
		columns: []
	};

	// Check if responsive has already been initialised on this table
	if ( this.s.dt.settings()[0].responsive ) {
		return;
	}

	// details is an object, but for simplicity the user can give it as a string
	if ( opts && typeof opts.details === 'string' ) {
		opts.details = { type: opts.details };
	}

	this.c = $.extend( true, {}, Responsive.defaults, DataTable.defaults.responsive, opts );
	settings.responsive = this;
	this._constructor();
};

Responsive.prototype = {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Constructor
	 */

	/**
	 * Initialise the Responsive instance
	 *
	 * @private
	 */
	_constructor: function ()
	{
		var that = this;
		var dt = this.s.dt;

		dt.settings()[0]._responsive = this;

		// Use DataTables' private throttle function to avoid processor thrashing
		$(window).on( 'resize.dtr orientationchange.dtr', dt.settings()[0].oApi._fnThrottle( function () {
			that._resize();
		} ) );

		// Destroy event handler
		dt.on( 'destroy.dtr', function () {
			$(window).off( 'resize.dtr orientationchange.dtr draw.dtr' );
		} );

		// Reorder the breakpoints array here in case they have been added out
		// of order
		this.c.breakpoints.sort( function (a, b) {
			return a.width < b.width ? 1 :
				a.width > b.width ? -1 : 0;
		} );

		// Determine which columns are already hidden, and should therefore
		// remain hidden. todo - should this be done? See thread 22677
		//
		// this.s.alwaysHidden = dt.columns(':hidden').indexes();

		this._classLogic();
		this._resizeAuto();

		// Details handler
		var details = this.c.details;
		if ( details.type ) {
			that._detailsInit();
			this._detailsVis();

			dt.on( 'column-visibility.dtr', function () {
				that._detailsVis();
			} );

			// Redraw the details box on each draw. This is used until
			// DataTables implements a native `updated` event for rows
			dt.on( 'draw.dtr', function () {
				dt.rows( {page: 'current'} ).iterator( 'row', function ( settings, idx ) {
					var row = dt.row( idx );

					if ( row.child.isShown() ) {
						var info = that.c.details.renderer( dt, idx );
						row.child( info, 'child' ).show();
					}
				} );
			} );

			$(dt.table().node()).addClass( 'dtr-'+details.type );
		}

		// First pass - draw the table for the current viewport size
		this._resize();
	},


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private methods
	 */

	/**
	 * Calculate the visibility for the columns in a table for a given
	 * breakpoint. The result is pre-determined based on the class logic if
	 * class names are used to control all columns, but the width of the table
	 * is also used if there are columns which are to be automatically shown
	 * and hidden.
	 *
	 * @param  {string} breakpoint Breakpoint name to use for the calculation
	 * @return {array} Array of boolean values initiating the visibility of each
	 *   column.
	 *  @private
	 */
	_columnsVisiblity: function ( breakpoint )
	{
		var dt = this.s.dt;
		var columns = this.s.columns;
		var i, ien;

		// Class logic - determine which columns are in this breakpoint based
		// on the classes. If no class control (i.e. `auto`) then `-` is used
		// to indicate this to the rest of the function
		var display = $.map( columns, function ( col ) {
			return col.auto && col.minWidth === null ?
				false :
				col.auto === true ?
					'-' :
					$.inArray( breakpoint, col.includeIn ) !== -1;
		} );

		// Auto column control - first pass: how much width is taken by the
		// ones that must be included from the non-auto columns
		var requiredWidth = 0;
		for ( i=0, ien=display.length ; i<ien ; i++ ) {
			if ( display[i] === true ) {
				requiredWidth += columns[i].minWidth;
			}
		}

		// Second pass, use up any remaining width for other columns. For
		// scrolling tables we need to subtract the width of the scrollbar. It
		// may not be requires which makes this sub-optimal, but it would
		// require another full redraw to make complete use of those extra few
		// pixels
		var scrolling = dt.settings()[0].oScroll;
		var bar = scrolling.sY || scrolling.sX ? scrolling.iBarWidth : 0;
		var widthAvailable = dt.table().container().offsetWidth - bar;
		var usedWidth = widthAvailable - requiredWidth;

		// Control column needs to always be included. This makes it sub-
		// optimal in terms of using the available with, but to stop layout
		// thrashing or overflow. Also we need to account for the control column
		// width first so we know how much width is available for the other
		// columns, since the control column might not be the first one shown
		for ( i=0, ien=display.length ; i<ien ; i++ ) {
			if ( columns[i].control ) {
				usedWidth -= columns[i].minWidth;
			}
		}

		// Allow columns to be shown (counting from the left) until we run out
		// of room
		var empty = false;
		for ( i=0, ien=display.length ; i<ien ; i++ ) {
			if ( display[i] === '-' && ! columns[i].control ) {
				// Once we've found a column that won't fit we don't let any
				// others display either, or columns might disappear in the
				// middle of the table
				if ( empty || usedWidth - columns[i].minWidth < 0 ) {
					empty = true;
					display[i] = false;
				}
				else {
					display[i] = true;
				}

				usedWidth -= columns[i].minWidth;
			}
		}

		// Determine if the 'control' column should be shown (if there is one).
		// This is the case when there is a hidden column (that is not the
		// control column). The two loops look inefficient here, but they are
		// trivial and will fly through. We need to know the outcome from the
		// first , before the action in the second can be taken
		var showControl = false;

		for ( i=0, ien=columns.length ; i<ien ; i++ ) {
			if ( ! columns[i].control && ! columns[i].never && ! display[i] ) {
				showControl = true;
				break;
			}
		}

		for ( i=0, ien=columns.length ; i<ien ; i++ ) {
			if ( columns[i].control ) {
				display[i] = showControl;
			}
		}

		// Finally we need to make sure that there is at least one column that
		// is visible
		if ( $.inArray( true, display ) === -1 ) {
			display[0] = true;
		}

		return display;
	},


	/**
	 * Create the internal `columns` array with information about the columns
	 * for the table. This includes determining which breakpoints the column
	 * will appear in, based upon class names in the column, which makes up the
	 * vast majority of this method.
	 *
	 * @private
	 */
	_classLogic: function ()
	{
		var that = this;
		var calc = {};
		var breakpoints = this.c.breakpoints;
		var columns = this.s.dt.columns().eq(0).map( function (i) {
			var className = this.column(i).header().className;

			return {
				className: className,
				includeIn: [],
				auto:      false,
				control:   false,
				never:     className.match(/\bnever\b/) ? true : false
			};
		} );

		// Simply add a breakpoint to `includeIn` array, ensuring that there are
		// no duplicates
		var add = function ( colIdx, name ) {
			var includeIn = columns[ colIdx ].includeIn;

			if ( $.inArray( name, includeIn ) === -1 ) {
				includeIn.push( name );
			}
		};

		var column = function ( colIdx, name, operator, matched ) {
			var size, i, ien;

			if ( ! operator ) {
				columns[ colIdx ].includeIn.push( name );
			}
			else if ( operator === 'max-' ) {
				// Add this breakpoint and all smaller
				size = that._find( name ).width;

				for ( i=0, ien=breakpoints.length ; i<ien ; i++ ) {
					if ( breakpoints[i].width <= size ) {
						add( colIdx, breakpoints[i].name );
					}
				}
			}
			else if ( operator === 'min-' ) {
				// Add this breakpoint and all larger
				size = that._find( name ).width;

				for ( i=0, ien=breakpoints.length ; i<ien ; i++ ) {
					if ( breakpoints[i].width >= size ) {
						add( colIdx, breakpoints[i].name );
					}
				}
			}
			else if ( operator === 'not-' ) {
				// Add all but this breakpoint (xxx need extra information)

				for ( i=0, ien=breakpoints.length ; i<ien ; i++ ) {
					if ( breakpoints[i].name.indexOf( matched ) === -1 ) {
						add( colIdx, breakpoints[i].name );
					}
				}
			}
		};

		// Loop over each column and determine if it has a responsive control
		// class
		columns.each( function ( col, i ) {
			var classNames = col.className.split(' ');
			var hasClass = false;

			// Split the class name up so multiple rules can be applied if needed
			for ( var k=0, ken=classNames.length ; k<ken ; k++ ) {
				var className = $.trim( classNames[k] );

				if ( className === 'all' ) {
					// Include in all
					hasClass = true;
					col.includeIn = $.map( breakpoints, function (a) {
						return a.name;
					} );
					return;
				}
				else if ( className === 'none' || className === 'never' ) {
					// Include in none (default) and no auto
					hasClass = true;
					return;
				}
				else if ( className === 'control' ) {
					// Special column that is only visible, when one of the other
					// columns is hidden. This is used for the details control
					hasClass = true;
					col.control = true;
					return;
				}

				$.each( breakpoints, function ( j, breakpoint ) {
					// Does this column have a class that matches this breakpoint?
					var brokenPoint = breakpoint.name.split('-');
					var re = new RegExp( '(min\\-|max\\-|not\\-)?('+brokenPoint[0]+')(\\-[_a-zA-Z0-9])?' );
					var match = className.match( re );

					if ( match ) {
						hasClass = true;

						if ( match[2] === brokenPoint[0] && match[3] === '-'+brokenPoint[1] ) {
							// Class name matches breakpoint name fully
							column( i, breakpoint.name, match[1], match[2]+match[3] );
						}
						else if ( match[2] === brokenPoint[0] && ! match[3] ) {
							// Class name matched primary breakpoint name with no qualifier
							column( i, breakpoint.name, match[1], match[2] );
						}
					}
				} );
			}

			// If there was no control class, then automatic sizing is used
			if ( ! hasClass ) {
				col.auto = true;
			}
		} );

		this.s.columns = columns;
	},


	/**
	 * Initialisation for the details handler
	 *
	 * @private
	 */
	_detailsInit: function ()
	{
		var that    = this;
		var dt      = this.s.dt;
		var details = this.c.details;

		// The inline type always uses the first child as the target
		if ( details.type === 'inline' ) {
			details.target = 'td:first-child';
		}

		// type.target can be a string jQuery selector or a column index
		var target   = details.target;
		var selector = typeof target === 'string' ? target : 'td';

		// Click handler to show / hide the details rows when they are available
		$( dt.table().body() ).on( 'click', selector, function (e) {
			// If the table is not collapsed (i.e. there is no hidden columns)
			// then take no action
			if ( ! $(dt.table().node()).hasClass('collapsed' ) ) {
				return;
			}

			// Check that the row is actually a DataTable's controlled node
			if ( ! dt.row( $(this).closest('tr') ).length ) {
				return;
			}

			// For column index, we determine if we should act or not in the
			// handler - otherwise it is already okay
			if ( typeof target === 'number' ) {
				var targetIdx = target < 0 ?
					dt.columns().eq(0).length + target :
					target;

				if ( dt.cell( this ).index().column !== targetIdx ) {
					return;
				}
			}

			// $().closest() includes itself in its check
			var row = dt.row( $(this).closest('tr') );

			if ( row.child.isShown() ) {
				row.child( false );
				$( row.node() ).removeClass( 'parent' );
			}
			else {
				var info = that.c.details.renderer( dt, row[0] );
				row.child( info, 'child' ).show();
				$( row.node() ).addClass( 'parent' );
			}
		} );
	},


	/**
	 * Update the child rows in the table whenever the column visibility changes
	 *
	 * @private
	 */
	_detailsVis: function ()
	{
		var that = this;
		var dt = this.s.dt;

		// Find how many columns are hidden
		var hiddenColumns = dt.columns().indexes().filter( function ( idx ) {
			var col = dt.column( idx );

			if ( col.visible() ) {
				return null;
			}

			// Only counts as hidden if it doesn't have the `never` class
			return $( col.header() ).hasClass( 'never' ) ? null : idx;
		} );
		var haveHidden = true;

		if ( hiddenColumns.length === 0 || ( hiddenColumns.length === 1 && this.s.columns[ hiddenColumns[0] ].control ) ) {
			haveHidden = false;
		}

		if ( haveHidden ) {
			// Show all existing child rows
			dt.rows( { page: 'current' } ).eq(0).each( function (idx) {
				var row = dt.row( idx );

				if ( row.child() ) {
					var info = that.c.details.renderer( dt, row[0] );

					// The renderer can return false to have no child row
					if ( info === false ) {
						row.child.hide();
					}
					else {
						row.child( info, 'child' ).show();
					}
				}
			} );
		}
		else {
			// Hide all existing child rows
			dt.rows( { page: 'current' } ).eq(0).each( function (idx) {
				dt.row( idx ).child.hide();
			} );
		}
	},


	/**
	 * Find a breakpoint object from a name
	 * @param  {string} name Breakpoint name to find
	 * @return {object}      Breakpoint description object
	 */
	_find: function ( name )
	{
		var breakpoints = this.c.breakpoints;

		for ( var i=0, ien=breakpoints.length ; i<ien ; i++¤) {
			ig ( break0ointsé].name`?== name ) {
				Beturn0brmakpomntu[i];
			}
		}J	?,


	/"*
	 * Adter the0|able display fos a res)zed vkewport. Tihs invodFes firqd
	 *"dEtermi~ILg wha4 Rreakp?énv the wkjdow ctrrentlñ"és in, gåôting the
	 *0column risibiliôies to$apply ant"then¢sitting tham.
	 *‚ * @p{awate
	 *
	_resize: ft.ktion  )"	{
		vap dt =0Thés.s.dô:
		va2"~idth ;$$(windKwi.widt@ ;
		vAr breakp%iNts =)tlis.c."pmakpoioôs
		va2 âreaktnint = breakpointsß0].namE;
		v`r colum.{!= thoó®R.coluenó;
		vaò&i, ien;

		// Deter}il- whad breakpoinv we crg currentmy at
™	for ($)=breakpoints.leîgth-1 ;0i<=0 ; i-- ) {Š)	if (8idth <] cReakpoj.Ts[i].wIdth ) {			bråaipoinu = breaKpïints[i].name;
			breik?
			|
	‰}
		
É)// Shgv`vhe co,mns foz vhat &reqk pomnt
		vas columnsVic = thks._columnsVisiblity( creakpoint m;

		¯ Set |(e"class båfore!vie column!visibin)ty is c|anged so eve.t
		// dkstenerS ë®ow wèat the stc<e is>(Need toa%etermioá if thmre are
	// an{ columnc vhat are .ot vkséble být!can be shown
		var colm` sedCdasw = fhìse;
		f/r ( i=5$ ien=codu}ns.length ; y4ien ; i+@) {
		If ( cnamnsVYsKi] === ®alse "" ! colu-js[i].neöer ) k				col]asedCdass = txµe?
				creak;
		}
		}
*	$( dT.table(¬/~ode()`).togglgCláss('colmapseg&,@collqp#edClasÓ");

	dt.columns().eq(0)/each("Dunctin ( colIdx, i ) iJ			dtªckxumn( ColIdx (.Visiblí, Colum^sVis[i] !
		} ©
},

	/**
	 * Determi^e the wi$th of(each coluin in thå table wo the au|o cole}/ hidhng*	 * j s that knformatimn to ÷ork wit(* Ôhis í%t`od ia"nmver g{ing to be 100%Š‰ * perfdbt sincÃ aolumh$wIdths can change(slightìy per paoe, bet#withoutj * sgRiously$ao}promiSing performancå this is qqite effectivá.
	 *
	 * @priv@te	 */*]gesizeC´vo: funcvion (({
		var dt = 4hès.s.dt;
		var cllumnw = this.scolum~c;*
		/ Are we b|`owed@tk do autm sizing?
		in (`! this.c.auto +4{
			repurn;
	ÿ

		// Are the2e any codumns"f`at actually n%%d auto?}izing, Or do dhay all
	i// have alassms definel		if ( $/inAr2aY( truM, $.map "k{lumnû,"functkol((c) { return"c.)uto;}0) ) ===(-1 ) {			retup~;
				// Clone the ,able mivh the current daua in ip
		var 4ableWé$4h   =€d4.table(-.node(;.offse|Wétth;
		vár coxumnWidtèc ½ dt.colõmns;Ivar c,onedTablE `= dtžtable().nkde()*cH~neNode( false )?
		v`r clonedXd`der = ¤) dt.t!bLe().ieader()¾clmneNolå( false0)).aptenDTo( choîedTable );
	™~a~ clo.dlBody   = $( dt>table()f ody()(cloneNoeefalså0) ).appgndTo( clnîedTable );

	$( dt.tAble().fooper() ).clone( dalse ).appendTï( clonedÜable¢);J
		/¦ This is0á0bit snoW, but we neet tg get a glone Of each bow that
	‰// inaìudes a|, coluíîã* As susH, try u/ do this as didtle aó possibla,
		dt.2î÷s( { pq7e: 'cuprent'`} «.indÅPds().fHat|en()®eagh( fwction . iDx ) {ª©	var Clmne = dp.row($id8 ).nodu().clolnode("true );
		
			if!( dt.goìtmns($%:jidden# ).flapten().ldNoth ) ;
			$(almne).appdnd( d|.cdlls( iäx, ':hiäden' 9,nmdes().t$().chole() )?
			}
)$(clone	.appen`To( clOnddBodi"©
		} );*
		varlcells = dt.cokumos().hgaäer()ntm$().c,onE( falce );
		$(g<tr/%)
			&append( ceLls )#	‰	.appgnÄTo( cio~edHea %z );

i	./ In the inlýne`case exura pafäing is&applidd to the`fmrst ck|umn tk
		// give0space gor thA0show ¯°hcde icon, We |ee$ to use this if&the
	// calculation
	if ( t(is.c.dediils.tyqd === 'inline ) {
			$(cloneDÀ`ble).addClass* '$tr-inline coll`Qsed' !;		}
		ar iOSerted =( ('<div/.')
		M.css( û
			wievè: 1,
		‰	height: 1,
			overflï: 'hilteN'
			}`+
			aðVend(0cxonedT!Blå );

Y	// Remvc cole=.q whic( `re nou to be klcludet		inse2t%d.find(£th.never, td*oi|er').remove();

		inwdrted.insertBefo2E  dt.able().~ode() )+
		// Thåpclon`d leadeq now conõðins thg smalls5 that eAbh cole}n can(ba
		dt*ãolumns(©*uq(0).aach( function  idx ) {		colu-nc[idx].minWidth! celló[ idx ].offsetWidph || 0;		} );

		inserted.rdeoVe();
	}};


?"j
 * HI{p of fcfaultèfruakpoynT3. Each item in the arvsx is aï object(÷éth twïJ!* prïpevtieszJ :
 * + àfame` - the bziakpoint name.
 * 2 `width` - tl' Òreakpoknt widuj
 *
 * @name Rdsxonsivo.break0oiNts
 . ÀótaticJ */
Responsivå.breakpïi&ts = [Š	q name: 3desktoa',  width: InfIjkty },
	{ name* 'tablgt%l', witth: 1124 },
	{ lqme: 'teblet-p., widt(z 368 },	y namõ:`/mobife-l', width: 480 },
	{ na-e: 'mofi,e-p', cidth:$321 }
];

/**
 > 2esponcife denhU(t sedtings fo2 initialiSatioj
€*
 * .qmespagu* @name Responskve.dEfaults
 * @statk# */
Re{ponsive.dEfaulpó ? {
	/**
	 * Lis of rruqkpoints for(phå insô nce. NOpa that Tè)s meals that each
	 *0ijstancd can háve"its osO breakpoénts. ddition#ìny, thå0`reaktnits
	(. #annot Be changed once0an instance haq been cr%csed.
	 *Š	 * À|xpe {Arre}}
	 *`€defaumt Takes the valqe of `Resðonsi>g.creakqnints`
	h*+
	breakpoints Respo~sIve.braakXoints,

	/**ª	 * Enablf / disAbne autÿ hiding c¡lculatèons. Id ãan hdl8 to inc²`ase
 * perfrå!nce r|ightly if¨you äisable ôxió optmçn, but cml columns woul,#	 * nue`1to hav$¡breakpoInt classes asciwned tï0Them
	!+
	 * @Type {Boonuan}
	"*!@defaelt  `tòQe`
	 *#
	auto:(true,

/**
	 * Fevails cï~trol+pIf given cs a ñuring vadUe, the `type`!p"npertY ÷l the
	 * default object is så| to th`tvalue. mnd thA defaults used fïr0the`re3t
	 *"ïg the mbject -&this ig fkr eardof impLementation.
	 *
	$* The object(ckLsists f the following Prope24hes:
	 *	 * * dsånderev`$- fõnction that is ce¬led for display /f thehi8ild r/Sdata®
!*   Vhg defau|t functinn will sXow txe lata fpïm the hidden co||mns
 . * `tcvget` - uñed as pha selectïr fos"wiat ob+ects to åttach the chill
 *   gren / Clo{e to
	 * * `type` - xæclse` to$disable the d%tails diÒxlay,!`Inline` r `co,umn`
	 j   for tha two control xyp%s
	 *
	`* @typl {Object|strifgy
	 */
	eetails; {
		rejdurer: vtnctiom ( api, 2neIdx ) {
			var data ? m0i.cehls( rowADp¬ ':hinden' ).eq¨0).map( funkt+/n ( ceì$ ) {
			var jaader  $( api.column( cell.column ).header()`8;Š				Ver(idx ="api.celì( cell$)¾indexi;
			iv`( header.hasÃ(`cs( 'control' ) || headå0.hasglass( 'nefår' ) 1!{
			)	raturnt';
			l
				¯/`Use a"non-public DT API(method‚vn rend%r the lat¡ for dIrplay				// ThÉs needs uo be(uPdated$7xan DT qdds a swi4able meuhod fg:				k-"This typu of da$a retRieral
			var dtPrivate =`api.settings()[0];
		iUIr celèData = Ä¶Qrivat%>oApi.fNgetCellÄata(
	‰		dtPrivate, iDx.row, mdx.column* 'dióplay'
			I	;
				var title = heAdd2.text+);
				iG ( titlu() {
	)		title 1 titiu! ':'
			}
*				reteòj '<li0data-dtrmindex¢'+idx.aïlqmn+'">'+
			‰	7<spaf class=&v|r-titl%">'+
	I)‰			tie,e+
						'</span> '+
	I			'<span clasr}"dtr-dcta">'+
	)				ce,L@ata+
	)				',¯3tan>'«
				'<+lh>';
	m ).t.Ar@ay().zïin(''¡;
			ru4urn data(?
		!	$¨'<ul data-dtò-index=¢#*vowIdx)'"/>').mpðend( pita ) :
/!		faìså8
		},
		tareutz 0,

type: 'I.line'(	}
};

Z/*
 * EPI
 */
sq² Api  $>fn.d!tã\able&Ápi;

// Doesn'w(do anyt`ing - uoR{ arouod for a0cõg in"DÐ&.. No4¸aocumdnted
Api&pegister($'responsive()', functiez () z
	òeturn tXis;
} );

Apmnrmgisteò( 'respmnsive.Indåx()', æ}nctio.$( li ) {
	li 9 $(li);

return {
		colUmn: li>d`ta('dtr-index').
		row: "  li.parent((.äíta('dtr-inde8!Š	};
} );

Api.registtr(!'responcive.reâuild(+'¬ function () {"	zeturl"t(is.i4erator( 'table', nenctio~ ’ ctx ) û
		i0 0ctx._rasponsiöe ) {
			Ctx._rd{ponsive
_classogic();
	}
	} 	:
} );
pi.reci3ôer( gòasponsiva.recaîc8)', fuNsüion () {
	rEtuzn this.iteratoR8 'tabhe', fuLcuyon (4ctz ) {
	‰Hf ( btxn_respoìSive ) ;J			ctpn_respknséve._rgkyzeAutoh!;
		(ctx._reshonsive._resize():
		}
	l );
} );


/**
 ( Versin`infor=ation
"k
 * @nae% Respnqive.vgrsaon
 *$@static */
Re7Ronsive¬varsion0=`¥1.0.6/;


$.fl/dataTsblå.Resxnnsive =Responsive;
$.f~.DataTAbLe.RespoNsive = Vespo.s)re;

/ Attacj(a listfner to tjp$documelp which xistens for DaôaTable{ initiadkuation/+ eventc`so we ‹`n aufomatical,y initial)se
$(d'aumenr8.on( 'énit.dt.äts', funcdion (e, setti~gs, json) {
	if *¡a.namesðace != #dt' )`{‚		retwrn;
	}jŠ	if ( $*settingsnnTablu).masClesr( 'respofsive' © ||
		 $(settkf'#.nTabla).hasìabs( 'd|iresponsiSe' ) ||		 suttings.kInit.reðknsive"~|		 DatáTable*default3.Pespon1ire
	) s
)	var i|it = s%t4jngs.ohnit.resTonsive;

		if (,énit !5? "alse - {
			new4Responrive( sgttings, $.isPlailkbjecd.(onit )¨ iniô :!{}  a;
		}
	}J} );

seTurn R%óponsiv%:
}; //`'æactor}


// Dufh.e as 0n AMD mïvule if$pOssiblE
áf ( typ%of dafiîe === 'nunction' && denmne.amd ) {
	d%f©ne( K'jsueryn /dataTables'], fáctorY ©9
}
else if (~y`eof e|ports 9y½ 'obj'ct' ) {
  ° // ^Mdå/Com}onNS
   ,çictory( requi`d('jquer}'), req5are('äatatablesg( );
}
else if*: jQueri .& !jQtery.fn.daTaTabLg.espo.save ) û
	// O`ierwise si}ply i~Atialise es normad, stophing muN5iple e~aluati/n	factory( jQuev{, jQudr}.fn.det@Pables);
}

}©)window, docuíEnp);
