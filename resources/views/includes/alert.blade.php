@if(session('msg'))
<div class="alert alert-{{session('type') ?? info}} mt-5">
    {{(session('msg'))}}
</div>
@endif