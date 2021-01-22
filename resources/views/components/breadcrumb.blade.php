<div>
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> @lang('admin.home')</a>
                    @if ($first)
                        › @if ($firstRoute)
                            <a href="{{ route($firstRoute) }}"> {{ $first }}</a>
                        @else
                            {{ $first }}
                        @endif
                    @endif
                    @if ($second)
                        › @if ($secondRoute)
                            <a href="{{ route($secondRoute) }}"> {{ $second }}</a>
                        @else
                            {{ $second }}
                        @endif
                    @endif
                </div>
               <div class="col-md-2 text-right mr-3">
                   {{ $slot }}
               </div>
            </div>
        </div>
    </div>
</div>
