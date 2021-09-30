<template>
    <head>
        <title>Company</title>
    </head>
    <div>
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Companies</h1>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Overview
                        </div>
                        <div class="card-body px-1 py-2">
                            <div class="row p-4">
                                <div class="col-md-12">
                                    <button @click="showCompanyForMdl" class="btn btn-primary"><i
                                        class="fas fa-plus"></i> Add Company
                                    </button>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <table id="companies-table" class="table table-bordered"
                                           style="width: 100%"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Company form -->
        <div class="modal fade" id="company-form-mdl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{ overview.title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-row">
                                <div class="mb-3 flex-grow-1 me-4">
                                    <label>Name</label>
                                    <input type="text" class="form-control" v-model="overview.name">
                                </div>
                                <div class="mb-3 flex-grow-1">
                                    <label>IQAMA / National ID</label>
                                    <input type="text" class="form-control" v-model="overview.iqama">
                                </div>
                            </div>
                            <div class="d-flex flex-row">
                                <div class="mb-3 flex-grow-1 me-4">
                                    <label>Email</label>
                                    <input type="email" class="form-control" v-model="overview.email">
                                </div>
                                <div class="mb-3 flex-grow-1">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" v-model="overview.phone">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Company Type</label>
                                <select class="form-select" v-model="overview.type">
                                    <option value="sra">Saudi Recruitment Agency</option>
                                    <option value="pra">Philippine Recruitment Agency</option>
                                    <option value="company">Company</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Address</label>
                                <textarea class="form-control" rows="2" v-model="overview.address"></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <textarea class="form-control" rows="2" v-model="overview.description"></textarea>
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
                name: '',
                description: '',
                address: '',
                phone: '',
                email: '',
                iqama: '',
                type: '',
                title: '',
            },
            companyFormMdl: null,
        }
    },
    methods: {
        showCompanyForMdl() {
            this.companyFormMdl.show();
            this.overview = {
                name: '',
                description: '',
                address: '',
                phone: '',
                email: '',
                iqama: '',
                type: '',
                title: 'New Company',
            };
        },
        store() {
            var $this = this;
            axios.post(this.data.cm_store_link, this.overview).then(function () {
                $this.dt.draw();
            });
        }
    },
    mounted() {
        const $this = this;

        $this.companyFormMdl = new bootstrap.Modal(document.getElementById('company-form-mdl'), {
            keyboard: false
        });

        $this.dt = $('#companies-table').DataTable({
            serverSide: true,
            ajax: {
                url: $this.data.companies_table_link,
                type: 'POST'
            },
            "order": [[0, "desc"]],
            "columns": [
                {"data": "id", "name": "id", "title": "ID"},
                {
                    "data": (value) => "<a href='#' class='btn btn-sm btn-link btn-name'>" + value.name + "</a>",
                    "name": "name",
                    "title": "Name"
                },
                {"data": "type", "name": "type", "title": "Type"},
                {"data": "iqama", "name": "iqama", "title": "IQAMA/National ID"},
                {"data": "phone", "name": "phone", "title": "Phone"},
                {"data": "email", "name": "email", "title": "E-mail"},
            ],
            drawCallback: function (settings) {
                $('.btn-name').on('click', function () {
                    $this.companyFormMdl.show();
                    $this.overview = $this.dt.row($(this).parent().parent()).data();
                    $this.overview.title = "Edit Company"
                });
            }
        });
    }
}
</script>

<style scoped>

</style>
