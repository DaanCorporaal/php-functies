<?php
header('Content-Type: text/xml');
print '<?xml version="1.0"?>' . "\n";
print "<shows>\n";

$shows = array(array('naam'=>'Simpsons',
                     'start'=>'Fox'));
foreach ($shows as $show){
    print "<show>\n";
    foreach ($show as $tag => $data){
        print "<$tag>" . htmlspecialchars($data) . "</$tag>\n";
    }
    print "</show>\n";
}
print "</shows>\n";