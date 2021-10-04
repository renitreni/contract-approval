<template>
    <head>
        <title>Cases</title>
    </head>
    <div>
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Cases</h1>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Overview
                        </div>
                        <div class="card-body px-1 py-2">
                            <div class="row p-4">
                                <div class="col-md-12">
                                    <button @click="showFormMdl" class="btn btn-primary"><i
                                        class="fas fa-plus"></i> Add Case
                                    </button>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <table id="cases-table" class="table table-bordered nowrap"
                                           style="width: 100%"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Company form -->
        <div class="modal fade" id="employer-form-mdl" data-bs-backdrop="static" data-bs-keyboard="false"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{ overview.title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-column">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <label>Agency / Company</label>
                                    <select id="select2-agencies" class="form-select select2"></select>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <label>Employer</label>
                                    <select id="select2-employers" class="form-select select2"></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <label>Worker</label>
                                    <select id="select2-worker" class="form-select select2"></select>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <label>ATNSIA No.</label>
                                    <input type="number" class="form-control" v-model="overview.atnsia_no">
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <label>Case Officer / Welfare</label>
                                    <input type="text" class="form-control" v-model="overview.case_officer">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-1">
                                    <label>Status</label>
                                    <select id="select2-status" class="form-control select2">
                                        <option value=""> -- None --</option>
                                        <option value="warning">Warning</option>
                                        <option value="suspended">Suspended</option>
                                        <option value="lifted">Lifted</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-lg-6" v-if="overview.status == 'suspended'">
                                    <label>Suspension Date</label>
                                    <input type="date" class="form-control" v-model="overview.suspension_date">
                                </div>
                                <div class="col-sm-12 col-lg-6" v-if="overview.status == 'suspended'">
                                    <label>No. Of Days Suspended</label>
                                    <input type="number" class="form-control" v-model="overview.days_suspended">
                                </div>
                                <div class="col-sm-12 col-lg-6" v-if="overview.status == 'lifted'">
                                    <label>Lifted Date</label>
                                    <input type="date" class="form-control" v-model="overview.lifted_date">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label>Nature of Complaint</label>
                                <textarea class="form-control" v-model="overview.complaint"></textarea>
                            </div>
                            <div class="col-12">
                                <label>Remarks</label>
                                <textarea class="form-control" v-model="overview.remarks"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="store">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "Cases",
    props: ['data'],
    data() {
        return {
            dt: null,
            overview: {
                'status': '',
                'company_id': '',
                'suspension_date': '',
                'lifted_date': '',
                'days_suspended': '',
                'employer_id': '',
                'case_officer': '',
                'worker_id': '',
                'atnsia_no': '',
                'complaint_id': '',
                'complaint': '',
                'remarks': '',
                'title': 'New Case',
            },
            caseFormMdl: null,
        }
    },
    methods: {
        showFormMdl() {
            this.caseFormMdl.show();
            $('.select2').val('').trigger('change');
            this.overview = {
                'status': '',
                'company_id': '',
                'suspension_date': '',
                'lifted_date': '',
                'days_suspended': '',
                'employer_id': '',
                'case_officer': '',
                'worker_id': '',
                'atnsia_no': '',
                'complaint_id': '',
                'complaint': '',
                'remarks': '',
                'title': 'New Case',
            };
        },
        store() {
            var $this = this;
            axios.post(this.data.cases_store_link, this.overview)
                .then(function () {
                    $this.dt.draw();
                });
        },
        select2Binder(id, value, label) {
            $(id).append('<option value="' + value + '">' + label + '</option>');
            $(id).val(value);
            $(id).trigger('change');
        }
    },
    mounted() {
        const $this = this;

        $this.caseFormMdl = new bootstrap.Modal(document.getElementById('employer-form-mdl'), {
            keyboard: false
        });

        $this.dt = $('#cases-table').DataTable({
            serverSide: true,
            "scrollX": true,
            ajax: {
                url: $this.data.cases_table_link,
                type: 'POST'
            },
            "order": [[0, "desc"]],
            "columns": [
                {"data": "id", "name": "id", "title": "ID"},
                {"data": "status_btn", "name": "status", "title": "Status"},
                {"data": "company.name", "name": "company.name", "title": "Agency / Company"},
                {"data": "company.type", "name": "company.type", "title": "Company Type"},
                {"data": "employer.name", "name": "employer.name", "title": "Employer"},
                {"data": "suspension_date_display", "name": "suspension_date", "title": "Suspension Date"},
                {"data": "days_suspended", "name": "days_suspended", "title": "Days Suspended"},
                {"data": "case_officer", "name": "case_officer", "title": "Case Officer"},
                {"data": "full_name", "name": "worker.last_name", "title": "Worker"},
                {"data": "atnsia_no", "name": "worker.atnsia_no", "title": "ATNSIA No."},
            ],
            drawCallback: function (settings) {
                $('.btn-name').on('click', function () {
                    $this.caseFormMdl.show();
                    $this.overview = $this.dt.row($(this).parent().parent()).data();
                    $this.overview.title = "Edit Case"

                    $this.select2Binder("#select2-agencies", $this.overview.company_id, $this.overview.company.name)
                    $this.select2Binder("#select2-worker", $this.overview.worker_id, $this.overview.full_name)
                    $this.select2Binder("#select2-employers", $this.overview.employer_id, $this.overview.employer.name)
                    $('#select2-status').val($this.overview.status).trigger('change');
                });
            }
        });

        $("#select2-agencies").select2({
            allowClear: true,
            placeholder: "-- Select Option --",
            theme: "bootstrap-5",
            ajax: {
                url: $this.data.list_agencies_link,
                dataType: 'json',
                method: 'POST',
            }
        }).on('select2:select', function (e) {
            $this.overview.company_id = e.params.data.id;
        });

        $("#select2-worker").select2({
            allowClear: true,
            placeholder: "-- Select Option --",
            theme: "bootstrap-5",
            ajax: {
                url: $this.data.list_workers_link,
                dataType: 'json',
                method: 'POST',
            }
        }).on('select2:select', function (e) {
            $this.overview.worker_id = e.params.data.id;
        });

        $("#select2-employers").select2({
            allowClear: true,
            placeholder: "-- Select Option --",
            theme: "bootstrap-5",
            ajax: {
                url: $this.data.list_employers_link,
                dataType: 'json',
                method: 'POST',
            }
        }).on('select2:select', function (e) {
            $this.overview.employer_id = e.params.data.id;
        });

        $("#select2-status").select2({
            allowClear: true,
            placeholder: "-- Select Option --",
            theme: "bootstrap-5",
        }).on('select2:select', function (e) {
            $this.overview.status = e.params.data.id;
        });
    }
}
</script>

<style scoped>

</style>
