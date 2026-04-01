FROM httpd:2.4-alpine

# Enable required modules by uncommenting them in httpd.conf
RUN sed -i \
    -e 's/^#LoadModule rewrite_module/LoadModule rewrite_module/' \
    -e 's/^#LoadModule proxy_module/LoadModule proxy_module/' \
    -e 's/^#LoadModule proxy_fcgi_module/LoadModule proxy_fcgi_module/' \
    -e 's/^#LoadModule deflate_module/LoadModule deflate_module/' \
    /usr/local/apache2/conf/httpd.conf

# Include the virtual hosts configuration
RUN echo "Include conf/extra/httpd-vhosts.conf" >> /usr/local/apache2/conf/httpd.conf
