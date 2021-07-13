
@include('cdn_js_css.home_js')


<script>

$(function(){
    let url = '{{ route('test_2') }}'
    window.location.assign(url);
}); 

</script>