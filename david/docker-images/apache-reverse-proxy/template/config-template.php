<?php
   $static_app1 = getenv('STATIC_APP1');
   $static_app2 = getenv('STATIC_APP2');
   $dynamic_app1 = getenv('DYNAMIC_APP1');
   $dynamic_app2 = getenv('DYNAMIC_APP2');
?>

<Proxy 'balancer://dynamic'>
   BalancerMember 'http://<?php print "$dynamic_app1"?>' route=1
   BalancerMember 'http://<?php print "$dynamic_app2"?>' route=2
   ProxySet stickysession=ROUTEID
</Proxy>

<Proxy 'balancer://static'>
   BalancerMember 'http://<?php print "$static_app1"?>' route=1
   BalancerMember 'http://<?php print "$static_app2"?>' route=2
   ProxySet stickysession=ROUTEID
</Proxy>

<VirtualHost *:80>
         ServerName demo.res.ch

         Header add Set-Cookie "ROUTEID=.%{BALANCER_WORKER_ROUTE}e; path=/" env=BALANCER_ROUTE_CHANGED

         ProxyPass '/api/animals/' 'balancer://dynamic/'
         ProxyPassReverse '/api/animals/' 'balancer://dynamic/'
         
         ProxyPass '/' 'balancer://static/'
         ProxyPassReverse '/' 'balancer://static/'
</VirtualHost>