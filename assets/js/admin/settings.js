(function ($, doc){
    "use strict";
    if( pagenow !== 'hustle_page_inc_hustle_settings' ) return;

    var E_News = Hustle.get("Settings.E_News"),
        Modules_Activity = Hustle.get("Settings.Modules_Activity"),
        Services = Hustle.get("Settings.Services");

    var e_new = new E_News();
    var m_activity = new Modules_Activity();
    var service = new Services();
}(jQuery, document));