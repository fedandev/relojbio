console.log('Inicio SW');

importScripts('js/sw-utils.js');


const STATIC_CACHE    = 'static-v4';
const DYNAMIC_CACHE   = 'dynamic-v2';
const INMUTABLE_CACHE = 'inmutable-v1';


const APP_SHELL = [
    // '/',       
    'js/sw-utils.js'
];

const APP_SHELL_INMUTABLE = [
    'js/plugins/jquery-3.1.1.min.js',
    'js/plugins/bootstrap.min.js',
    'js/plugins/jquery.metisMenu.js',
    'js/plugins/jquery.slimscroll.min.js',
    'js/plugins/footable.all.min.js',
    'js/plugins/inspinia.js',
    'js/plugins/select2.full.min.js',
    'js/plugins/toastr.min.js',
    'js/plugins/icheck.min.js',
    'js/plugins/summernote.min.js',
    'js/plugins/bootstrap-datepicker.js',
    'js/plugins/jasny-bootstrap.min.js',
    'js/plugins/highcharts.js',
    'js/plugins/exporting.js',
    'css/bootstrap.min.css',
    'css/plugins/font-awesome.css',
    'css/plugins/footable.core.css',
    'css/plugins/datepicker3.css',
    'css/plugins/select2.min.css',
    'css/plugins/toastr.min.css',
    'css/plugins/style.css',
    'css/plugins/custom-checkbox.css',
    'css/plugins/summernote/summernote.css',
    'css/plugins/summernote/summernote-bs3.css',
    'css/plugins/clockpicker.css',
    'css/custom.css',
    'css/highcharts.css'
    
];


self.addEventListener('install', e => {
    console.log('SW: Install');

    const cacheStatic = caches.open( STATIC_CACHE ).then(cache => 
        cache.addAll( APP_SHELL ));

    const cacheInmutable = caches.open( INMUTABLE_CACHE ).then(cache => 
        cache.addAll( APP_SHELL_INMUTABLE ));

    e.waitUntil( Promise.all([ cacheStatic, cacheInmutable ])  );
    
    
    //self.skipWaiting();
});


self.addEventListener('activate', e => {
    console.log('SW: Activate');
    const respuesta = caches.keys().then( keys => {

        keys.forEach( key => {

            if (  key !== STATIC_CACHE && key.includes('static') ) {
                return caches.delete(key);
            }

            if (  key !== DYNAMIC_CACHE && key.includes('dynamic') ) {
                return caches.delete(key);
            }

        });

    });

    e.waitUntil( respuesta );

});



self.addEventListener('fetch', event =>{
    if(event.request.url.includes('.css') || event.request.url.includes('.js') || event.request.url.includes('.jpg') || event.request.url.includes('.png')){
        //event.respondWith( fetch(event.request.url ));
        const respuesta = caches.match( event.request ).then( res => {

            if ( res ) {
                return res;
            } else {
    
                return fetch( event.request ).then( newRes => {
    
                    return actualizaCacheDinamico( DYNAMIC_CACHE, event.request, newRes );
    
                });
    
            }
    
        });
    
    
    
        event.respondWith( respuesta );
    }
;})