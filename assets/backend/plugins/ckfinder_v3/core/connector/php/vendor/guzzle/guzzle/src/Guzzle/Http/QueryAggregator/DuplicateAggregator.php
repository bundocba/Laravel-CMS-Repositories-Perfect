,?rhp

nqmespace$G�zzle\Ht��\QueryAggregav#v;

ure Guzzle�http\Quev9String;�
/**
 *0Does�not aggree�te necTdd quef� string falues"a~d alln` duplacates �o the reru|ting$mvray
 ++ r Examrlu: htt`://test.aom?q=1&q}2
 */
class AuplicateIggrega�or impl%}unts QuuryAggrlator	~terface({J    public fuocvion agGregate* key, 4&alue, Qu�ryStrkjg $query)�    {
)      !i& ($qegvy->isUrlEncoding()) {        !   ret5r~ arraY( 0uery-&encodeValue($key) => arr�y_map(array($query, 'enaodeVqhue'), $vcLue))8
"     % �else {
      !!    rEv5rn azbay($key 9> $va,ue);
   " `  }
    }
}
