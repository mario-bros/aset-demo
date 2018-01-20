var PortletTools = function () {
    //== Toastr
    var initToastr = function() {
        toastr.options.showDuration = 1000;
    }

    //== Demo 1
    var demo1 = function() {
        // This portlet is lazy initialized using data-portlet="true" attribute. You can access to the portlet object as shown below and override its behavior
        var portlet = $('#m_portlet_tools_1').mPortlet();

        portlet.collapse();
    }

    return {
        //main function to initiate the module
        init: function () {
            initToastr();

            // init demos
            demo1();
        }
    };
}();

jQuery(document).ready(function() {
    PortletTools.init();
});