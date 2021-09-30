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
        <div class="modal fade" id="employer-form-mdl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{ overview.title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-sm-column flex-lg-row">
                                <div class="mb-3 flex-grow-1 me-4">
                                    <label>Name</label>
                                    <input type="text" class="form-control" v-model="overview.name">
                                </div>
                                <div class="mb-3 flex-grow-1">
                                    <label>IQAMA/National ID</label>
                                    <input type="text" class="form-control" v-model="overview.iqama">
                                </div>
                            </div>
                            <div class="d-flex flex-sm-column flex-lg-row">
                                <div class="mb-3 flex-grow-1 me-4">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" v-model="overview.phone">
                                </div>
                                <div class="mb-3 flex-grow-1">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control" v-model="overview.email">
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="mb-3 flex-grow-1 me-4">
                                    <label>Address</label>
                                    <input type="text" class="form-control" v-model="overview.address">
                                </div>
                                <div class="mb-3 flex-grow-1">
                                    <label>Description</label>
                                    <textarea class="form-control" v-model="overview.description"></textarea>
                                </div>
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
    name: "Employer",
    props: ['data'],
    data() {
        return {
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
                'title': 'New Employer',
            },
            employerFormMdl: null,
        }
    },
    methods: {
        showFormMdl() {
            this.employerFormMdl.show();
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
                'title': 'New Employer',
            };
        },
        store() {
            var $this = this;
            axios.post(this.data.employer_store_link, this.overview)
                .then(function () {
                    $this.dt.draw();
                });
        }
    },
    mounted() {
        const $this = this;

        $this.employerFormMdl = new bootstrap.Modal(document.getElementById('employer-form-mdl'), {
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
                {"data": "status", "name": "status", "title": "Status"},
                {"data": "company.name", "name": "company.name", "title": "Company"},
                {"data": "company.type", "name": "company.type", "title": "Company Type"},
                {"data": "employer.name", "name": "employer.name", "title": "Employer"},
                {"data": "suspension_date", "name": "suspension_date", "title": "Suspension Date"},
                {"data": "days_suspended", "name": "days_suspended", "title": "Days Suspended"},
                {"data": "case_officer", "name": "case_officer", "title": "Case Officer"},
                {"data": "full_name", "name": "worker.last_name", "title": "Worker"},
                {"data": "atnsia_no", "name": "worker.atnsia_no", "title": "ATNSIA No."},
            ],
            drawCallback: function (settings) {
                $('.btn-name').on('click', function () {
                    $this.employerFormMdl.show();
                    $this.overview = $this.dt.row($(this).parent().parent()).data();
                    $this.overview.title = "Edit Case"
                });
            }
        });
    }
}
</script>

<style scoped>

</style>
