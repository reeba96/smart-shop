{{-- Load the css file to the header --}}
<script type="text/javascript">
    function loadCSS(filename) {
        var file = document.createElement("link");
        file.setAttribute("rel", "stylesheet");
        file.setAttribute("type", "text/css");
        file.setAttribute("href", filename);

        if (typeof file !== "undefined"){
            document.getElementsByTagName("head")[0].appendChild(file)
        }
    }
    loadCSS({!! '"'.asset('https://cdn.datatables.net/v/bs4/dt-' . ICBTECH\Helpdesk\Helpers\Cdn::DataTables . '/r-' . ICBTECH\Helpdesk\Helpers\Cdn::DataTablesResponsive . '/datatables.min.css').'"' !!});
    @if($editor_enabled)
        loadCSS({!! '"'.asset('https://cdnjs.cloudflare.com/ajax/libs/summernote/' . ICBTECH\Helpdesk\Helpers\Cdn::Summernote . '/summernote-bs4.css').'"' !!});
        @if($include_font_awesome)
            loadCSS({!! '"'.asset('https://use.fontawesome.com/releases/v' . ICBTECH\Helpdesk\Helpers\Cdn::FontAwesome5 . '/css/solid.css').'"' !!});
            loadCSS({!! '"'.asset('https://use.fontawesome.com/releases/v' . ICBTECH\Helpdesk\Helpers\Cdn::FontAwesome5 . '/css/fontawesome.css').'"' !!});
        @endif
        @if($codemirror_enabled)
            loadCSS({!! '"'.asset('https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . ICBTECH\Helpdesk\Helpers\Cdn::CodeMirror . '/codemirror.min.css').'"' !!});
            loadCSS({!! '"'.asset('https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . ICBTECH\Helpdesk\Helpers\Cdn::CodeMirror . '/theme/'.$codemirror_theme.'.min.css').'"' !!});
        @endif
    @endif
</script>