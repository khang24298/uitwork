DirectoryIndex index.php

<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On
    
    RewriteCond %{HTTP:Authorization} ^(.*)
    RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]
    
    RewriteCond %{REQUEST_URI}::$1 ^(/.+)/(.*)::\2$
    RewriteRule ^(.*) - [E=BASE:%1]

    RewriteCond %{ENV:REDIRECT_STATUS} ^$
    RewriteRule ^index\.php(/(.*)|$) %{ENV:BASE}/$2 [R=301,L]

    RewriteCond %{REQUEST_FILENAME} -f
    RewriteRule .? - [L]

    RewriteRule .? %{ENV:BASE}/index.php [L]

</IfModule>
