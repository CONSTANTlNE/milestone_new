@foreach($locales as $index => $locale)
    <p class="text-center mt-3 mb-3">Short Description - {{$locale->abbr}}</p>
    <div id="editor{{$index}}" style="overflow-y: hidden" class="mb-3">
        {!! $service->getTranslation('short_description',$locale->abbr) !!}
    </div>
@endforeach

<script>





    var toolbarOptions = [
        [{'header': [1, 2, 3, 4, 5, 6, false]}],
        [{'font': []}],
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],

        [{'header': 1}, {'header': 2}],               // custom button values
        [{'list': 'ordered'}, {'list': 'bullet'}],
        [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
        [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent
        [{'direction': 'rtl'}],                         // text direction

        [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown

        [{'color': []}, {'background': []}],          // dropdown with defaults from theme
        [{'align': []}],

        ['link','image', 'video'],
        ['clean']                                         // remove formatting button
    ];

    locales = @json($locales);
    locales.forEach((locale, index) => {
        setTimeout(() => {
            new Quill(`#editor${index}`, {
                modules: {
                    toolbar: toolbarOptions,
                    // imageResize: {
                    //     modules: ['Resize', 'DisplaySize', 'Toolbar']
                    // }
                },
                theme: 'snow'
            });


        }, 120)


    });
    setTimeout(() => {
        let toolbars = document.querySelectorAll('.ql-toolbar')
        toolbars.forEach((t) => {
            t.style.display = 'flex';
            t.style.flexWrap = 'wrap';
            // t.style.overflow = 'hidden';
        });
    }, 150)



</script>