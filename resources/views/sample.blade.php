<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>

</head>
<body>
<div class="container">
    <div id="app" class="d-flex flex-column">
        <div class="row justify-content-center vh-100">
            <div class="col-lg-6 col-sm-12 my-auto">
                <div class="d-flex flex-column">
                    <div class="input-group mb-3">
                        <select type="text" id="select2-agencies" class="form-control"></select>
                        <button class="btn btn-primary" type="button" @click="searchCase">
                            <i class="fas fa-search"></i> Search Result
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="mdl-status" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Status Pop-up</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <span class="fs-2 badge rounded-pill bg-primary">@{{ status }}</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ"
        crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{ asset('vendor/select2-bs5/index.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('vendor/select2-bs5/bs5-theme.min.css') }}"/>
<script src="{{ asset('vendor/select2-bs5/index.min.js') }}"></script>
<script src="https://unpkg.com/vue@next"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Vue.createApp({
        data() {
            return {
                keyword: '',
                case_results: [],
                mdl_status: null,
                overview: {},
                status: '',
            }
        },
        methods: {
            searchCase() {
                let $this = this;
                axios.post('{{ route('search.company') }}', $this.overview).then(function (value) {
                    $this.status = value.data.status;
                    $this.mdl_status.show();
                });
            }
        },
        mounted() {
            let $this = this;
            $this.mdl_status = new bootstrap.Modal(document.getElementById('mdl-status'), {
                keyboard: false
            })

            $("#select2-agencies").select2({
                allowClear: true,
                placeholder: "Type In Company Name...",
                theme: "bootstrap-5",
                ajax: {
                    url: '{{ route('list.agencies') }}',
                    dataType: 'json',
                    method: 'POST',
                }
            }).on('select2:select', function (e) {
                $this.overview.company_id = e.params.data.id;
            });
        }
    }).mount('#app');
</script>
</body>
</html>
