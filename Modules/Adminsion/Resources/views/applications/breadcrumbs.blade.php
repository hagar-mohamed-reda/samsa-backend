@section('breadcrumbs')
 <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">MSA</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ url('/qualifications') }}">المؤهلات الدراسية</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
@endsection
