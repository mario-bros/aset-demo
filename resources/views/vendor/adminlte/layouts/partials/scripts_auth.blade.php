<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ url('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/demo/demo3/base/scripts.bundle.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/snippets/pages/user/login.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/app/js/jquery.backstretch.min.js') }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->

<script>
    // To attach Backstrech as the body's background
    //$.backstretch("path/to/image.jpg");

    jQuery(document).ready(function() {

        // Or, to start a slideshow, just pass in an array of images
        $.backstretch([
            "{{ url('assets/app/media/img/bg/gpib-1.jpg') }}",
            "{{ url('assets/app/media/img/bg/gpib-2.jpg') }}",
            "{{ url('assets/app/media/img/bg/gpib-3.jpg') }}",
            "{{ url('assets/app/media/img/bg/gpib-4.jpg') }}",
            "{{ url('assets/app/media/img/bg/gpib-5.jpg') }}"
        ], {duration: 10000})
    });

    // Or, to load from a url that can accept a resolution and provide the best image for that resolution
    /*$(".foo").backstretch([
        "path/to/image.jpg?width={width}&height={height}"
    ]);*/

    // Or, to automatically choose from a set of resolutions.
    // The width is the width of the image, and the algorithm chooses the best fit.
    /*$(".foo").backstretch([
        [
            { width: 1080, url: "path/to/image1_1080.jpg" },
            { width: 720, url: "path/to/image1_720.jpg" },
            { width: 320, url: "path/to/image1_320.jpg" }
        ],
        [
            { width: 1080, url: "path/to/image2_1080.jpg" },
            { width: 720, url: "path/to/image2_720.jpg" },
            { width: 320, url: "path/to/image2_320.jpg" }
        ]
    ])*/

    // If we wanted to specify different images for different pixel-ratios:
    /*$(".foo").backstretch([
        [
            // Will only be chosed for a @2x device
            { width: 1080, url: "path/to/image1_1080@2x.jpg", pixelRatio: 2 },

            // Will only be chosed for a @1x device
            { width: 1080, url: "path/to/image1_1080.jpg", pixelRatio: 1 },

            { width: 720, url: "path/to/image1_720@2x.jpg", pixelRatio: 2 },
            { width: 720, url: "path/to/image1_720.jpg", pixelRatio: 1 },
            { width: 320, url: "path/to/image1_320@2x.jpg",  pixelRatio: 2 },
            { width: 320, url: "path/to/image1_320.jpg", pixelRatio: 1 }
        ]
    ])*/

    // If we wanted the browser to automatically choose from a set of resolutions,
    // While considering the pixel-ratio of the device
    /*$(".foo").backstretch([
        [
            // Will be chosen for a 2160 device or a 1080*2 device
            { width: 2160, url: "path/to/image1_2160.jpg", pixelRatio: "auto" },

            // Will be chosen for a 1080 device or a 540*2 device
            { width: 1080, url: "path/to/image1_1080.jpg", pixelRatio: "auto" },

            // Will be chosen for a 1440 device or a 720*2 device
            { width: 1440, url: "path/to/image1_1440.jpg", pixelRatio: "auto" },
            { width: 720, url: "path/to/image1_720.jpg", pixelRatio: "auto" },
            { width: 640, url: "path/to/image1_640.jpg", pixelRatio: "auto" },
            { width: 320, url: "path/to/image1_320.jpg", pixelRatio: "auto" }
        ]
    ])*/
</script>