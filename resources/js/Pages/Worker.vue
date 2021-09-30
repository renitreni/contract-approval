<template>
    <head>
        <title>Workers</title>
    </head>
    <div>
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Workers</h1>
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
                                        class="fas fa-plus"></i> Add Worker
                                    </button>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <table id="workers-table" class="table table-bordered"
                                           style="width: 100%"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Company form -->
        <div class="modal fade" id="worker-form-mdl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                                    <label>First Name</label>
                                    <input type="text" class="form-control" v-model="overview.first_name">
                                </div>
                                <div class="mb-3 flex-grow-1 me-4">
                                    <label>Middle Name</label>
                                    <input type="text" class="form-control" v-model="overview.middle_name">
                                </div>
                                <div class="mb-3 flex-grow-1">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" v-model="overview.last_name">
                                </div>
                            </div>
                            <div class="d-flex flex-sm-column flex-lg-row">
                                <div class="mb-3 flex-grow-1 me-4">
                                    <label>Birth Date</label>
                                    <input type="date" class="form-control" v-model="overview.birth_date">
                                </div>
                                <div class="mb-3 flex-grow-1 me-4">
                                    <label>Gender</label>
                                    <select class="form-select" v-model="overview.gender">
                                        <option value="m">Male</option>
                                        <option value="f">Female</option>
                                    </select>
                                </div>
                                <div class="mb-3 flex-grow-1 me-4">
                                    <label>Passport</label>
                                    <input type="text" class="form-control" v-model="overview.passport">
                                </div>
                            </div>
                            <div class="d-flex flex-sm-column flex-lg-row">
                                <div class="mb-3 flex-grow-1 me-4">
                                    <label>Email</label>
                                    <input type="email" class="form-control" v-model="overview.email">
                                </div>
                                <div class="mb-3 flex-grow-1 me-4">
                                    <label>Phone</label>
                                    <input type="phone" class="form-control" v-model="overview.phone">
                                </div>
                                <div class="mb-3 flex-grow-1 me-4">
                                    <label>IQAMA / National ID</label>
                                    <input type="email" class="form-control" v-model="overview.iqama">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Current Address</label>
                                <textarea class="form-control" v-model="overview.current_address"></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Permanent Address</label>
                                <textarea class="form-control" v-model="overview.permanent_address"></textarea>
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
    name: "Company",
    props: ['data'],
    data() {
        return {
            overview: {
                'first_name': '',
                'middle_name': '',
                'last_name': '',
                'birth_date': '',
                'passport': '',
                'email': '',
                'phone': '',
                'iqama': '',
                'current_address': '',
                'permanent_address': '',
                'gender': 'm',
                'title': 'New Worker',
            },
            workerFormMdl: null,
        }
    },
    methods: {
        showFormMdl() {
            this.workerFormMdl.show();
            this.overview = {
                'first_name': '',
                'middle_name': '',
                'last_name': '',
                'birth_date': '',
                'gender': 'm',
                'passport': '',
                'email': '',
                'phone': '',
                'iqama': '',
                'current_address': '',
                'permanent_address': '',
                'title': 'New Worker',
            };
        },
        store() {
            var $this = this;
            axios.post(this.data.worker_store_link, this.overview)
                .then(function () {
                    $this.dt.draw();
                });
        }
    },
    mounted() {
        const $this = this;

        $this.workerFormMdl = new bootstrap.Modal(document.getElementById('worker-form-mdl'), {
            keyboard: false
        });

        $this.dt = $('#workers-table').DataTable({
            serverSide: true,
            ajax: {
                url: $this.data.worker_table_link,
                type: 'POST'
            },
            "order": [[0, "desc"]],
            "columns": [
                {"data": "id", "name": "id", "title": "ID"},
                {
                    "data": (value) => "<a href='#' class='btn btn-sm btn-link btn-name'>" + value.last_name + ", " + value.first_name + "</a>",
                    "name": "last_name",
                    "title": "Full Name"
                },
                {"data": "passport", "name": "passport", "title": "Passport"},
                {"data": "iqama", "name": "iqama", "title": "IQAMA/National ID"},
                {"data": "email", "name": "email", "title": "Email"},
                {"data": "phone", "name": "phone", "title": "Phone"},
            ],
            drawCallback: function (settings) {
                $('.btn-name').on('click', function () {
                    $this.workerFormMdl.show();
                    $this.overview = $this.dt.row($(this).parent().parent()).data();
                    $this.overview.title = "Edit Worker"
                });
            }
        });
    }
}
</script>

<style scoped>

</style>
