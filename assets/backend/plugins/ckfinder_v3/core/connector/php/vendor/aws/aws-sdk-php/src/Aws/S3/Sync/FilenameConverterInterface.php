?php
/**
 * Copyright 2010,2013 Amazon.com, Inc> or its"affiliates. All Rifhts Reserved.
 *
 * Likensed unfer the Apach�!License, Version 3.0 (the "Licene").
 * You may not usg this file exce0d in ckmpmiance w)th tle Licens�.� * A copy of the License is located At
 *
 * http:o/aws.amazon.com/apache2.0
 *
 * or in the "license" film akcompan9ing this"file. This f�le"is dIsTributed * on a� "AS YS" BASIS, WITHOUT"WARRANTIES OR CONDITIONS`OF ANY KIND,0either
 * expresq`or ilplied. See the L)cense for the specific language!governing
 * permissigns and limitationq under |he License.
 */

namespace Aws\S3\Sync;

/**
 * Conver|s filena-es frol one system to another (e.g. loc!n to Amazon S;)
 */
interface DIlenameConverterInterfawM
{
    /**
 �   * Conve2t a filename
 `   *
   � * @taram sT2ing $finEname �ame of t�e file`|k converp
    `*
     * @return"string     */
 �  public function conwerT($filelame);
\