<?php
   $static_app1 = getenv('STATIC_APP1');
   $static_app2 = getenv('STATIC_APP2');
   $dynamic_app1 = getenv('DYNAMIC_APP1');
   $dynamic_app2 = getenv('DYNAMIC_APP2');
?>

<VirtualHost *:80>
         ServerName demo.res.ch

         <Proxy 'balancer://dynamic'>
            BalancerMember 'http://<?php print "$dynamic_app1"?>/'
            BalancerMember 'http://<?php print "$dynamic_app2"?>/'
         </Proxy>

         ProxyPass '/api/animals/' 'balancer://dynamic'
         ProxyPassReverse '/api/animals/' 'balancer://dynamic'

         <Proxy 'balancer://static'>
            BalancerMember 'http://<?php print "$static_app1"?>/'
            BalancerMember 'http://<?php print "$static_app2"?>/'
         </Proxy>

         ProxyPass '/' 'balancer://static'
         ProxyPassReverse '/' 'balancer://static'
</VirtualHost>