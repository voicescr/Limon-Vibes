$(document).ready(function () {
i18next
  .use(i18nextHttpBackend)
  .init({
      lng: 'en',
      backend: {
          loadPath: 'locales/{{lng}}/{{ns}}.json'
      },
      //fallbackLng: 'es', 
      debug: true,
    }, function(err, t) {
      jqueryI18next.init(i18next, $);
      $('.body').localize();
      $('.lang-select').click(function() {
        i18next.changeLanguage(this.innerHTML, function() {
           $('.nav-header').localize();
           $('.slides').localize();                           
           $('.s-holder').localize();  
           $('.fh5co-features').localize();  
           $('.tourAct').localize();  
           $('.fh5co-testimonial').localize();  
           $('.fh5co-contact').localize();     
           $('.pgFooter').localize();     
           $('.fh5co-about').localize();                                                      
        });
      });
  });
});
