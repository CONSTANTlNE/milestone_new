<script>
    var menus = {
        "oneThemeLocationNoMenus": "",
        "moveUp": '{{__("strings.move_up")}}',
        "moveDown": '{{__("strings.move_down")}}',
        "moveToTop": '{{__("strings.move_top")}}',
        "moveUnder": '{{__("strings.move_under")}}',
        "moveOutFrom": '{{__("strings.move_out_from")}}',
        "under": '{{__("strings.under")}}',
        "outFrom": '{{__("strings.out_from")}}',
        "menuFocus": '{{__("strings.menu_focus")}}',
        "deleteMenu": '{{__("strings.deleting_this_menu")}}',
        "enterMenuName": '{{__("strings.enter_menu_name")}}',
        "subMenuFocus" : '{{__("strings.submenu_focus")}}'
    };
    var arraydata = [];
    var addcustommenur = '{{ route("backend.menus.items.create") }}';
    var updateitemr = '{{ route("backend.menus.items.update")}}';
    var generatemenucontrolr = '{{ route("backend.menus.update") }}';
    var deleteitemmenur = '{{ route("backend.menus.items.delete") }}';
    var deletemenugr = '{{ route("backend.menus.destroy") }}';
    var createnewmenur = '{{ route("backend.menus.store") }}';
    var csrftoken = "{{ csrf_token() }}";
    var menuwr = "{{ url()->current() }}";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrftoken
        }
    });
</script>
<script type="text/javascript" src="{{asset('admin/menu/scripts.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/menu/scripts2.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/menu/menu.js')}}"></script>
