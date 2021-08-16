<template>
    <div>
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">My Contracts</h1>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            My Contracts Data Table
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary" @click="showAddContract">Add a Contract</button>
                                </div>
                                <div class="col-12 mt-3">
                                    <table id="contracts-table" class="table table-hover table-bordered"
                                           style="width: 100%"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contract Add Modal -->
        <div id="contract-add-modal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Contract Add Modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submit">
                            <div class="d-flex flex-column flex-md-fill">
                                <div class="d-flex">
                                    <label class="flex-grow-1 mb-3">
                                        Contract Type
                                        <select class="form-select" v-model="overview.type"
                                                v-bind:class="{'is-invalid': overview.type === ''}">
                                            <option value="">-- Select Option --</option>
                                            <option
                                                value="(Standard Contract) Household Service Worker Contract">
                                                (Standard Contract) Household Service Worker Contract
                                            </option>
                                            <option
                                                value="(Standard Contract) Skilled Worker Contract">
                                                (Standard Contract) Skilled Worker Contract
                                            </option>
                                            <option
                                                value="(BM Contract) Household Service Worker Contract">
                                                (BM Contract) Household Service Worker Contract
                                            </option>
                                            <option
                                                value="(BM Contract) Skilled Worker Contract">
                                                (BM Contract) Skilled Worker Contract
                                            </option>
                                        </select>
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-6 text-center" v-for="item in overview.details">
                                        <label class="flex-grow-1 mb-3">
                                            {{ item.label }}
                                            <input class="form-control"
                                                   v-bind:name="item.name"
                                                   type="file"
                                                   v-bind:class="{'is-invalid': item.value === ''}"
                                                   @input="item.value = $event.target.files[0]">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" @click="save()">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contract Overview Modal -->
        <div id="contract-overview-modal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Contract Overview Of {{ other_details.type }} <u>{{ other_details.custom_id }}</u></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-md-center">
                            <div class="col-md-6 border p-3 d-flex flex-column" v-for="item in contents">
                                <button class="btn btn-primary" @click="viewImage(item.value)">{{ item.label }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contract Overview Modal -->
        <div id="contract-image-modal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Contract Overview Of <u>{{ other_details.custom_id }}</u></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img v-bind:src="'/storage/' + image_path" style="width:100%">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "My Contracts",
        props: ['data', 'errors'],
        data() {
            return {
                dt: null,
                contract_add_modal: null,
                contract_overview_modal: null,
                overview: this.$inertia.form({
                    type: '',
                    details: [
                        {'label': 'Contract', 'name': 'contract', 'value': ''},
                        {'label': 'Request Letter', 'name': 'request-letter', 'value': ''},
                        {'label': 'Job Order - CHAMBERED', 'name': 'job-order', 'value': ''},
                        {'label': 'Visa Issued by ENJAZ with English Text', 'name': 'visa', 'value': ''},
                        {'label': 'Special Power of Attorney - CHAMBERED', 'name': 'spa', 'value': ''},
                        {'label': 'Recruitment Agreement', 'name': 'rec-agreement', 'value': ''},
                        {'label': 'Master Employment Contract - CHAMBERED', 'name': 'master-emp-contract', 'value': ''},
                        {'label': 'Commercial Registration', 'name': 'comm-registration', 'value': ''},
                        {
                            'label': 'Commercial Activity License / Business License',
                            'name': 'business-license',
                            'value': ''
                        },
                        {'label': 'POEA License of Philippine Agency', 'name': 'poea-license', 'value': ''},
                        {'label': 'Contingency Plan', 'name': 'contingency-plan', 'value': ''},
                        {'label': 'Affidavit of Undertaking', 'name': 'affidavit', 'value': ''},
                        {'label': 'Copy of Employer\'s ID / Passport', 'name': 'employer_id', 'value': ''},
                        {'label': 'List Of Current Filipino Workers', 'name': 'current-filipino-workers', 'value': ''},
                        {'label': 'Location Sketch Of The Company', 'name': 'location-sketch', 'value': ''},
                        {'label': 'Pictures of Workers\' Accommodation', 'name': 'workers-accomodation', 'value': ''},
                        {
                            'label': 'Motor Vehicle Insurance Policy (for DRIVERS)',
                            'name': 'vehicle-insurance',
                            'value': ''
                        },
                        {'label': 'Other Required Documents', 'name': 'other-documents', 'value': ''},
                    ]
                }),
                contents: {},
                other_details: {},
                image_path: '',
            }
        },
        methods: {
            save() {
                var $this = this;
                this.overview.post(this.data.contract_store_link, {
                    preserveScroll: true,
                    onSuccess: function () {
                        $this.overview.reset();
                        $this.contract_add_modal.hide();
                        $this.dt.draw();
                    }
                });
            },
            showAddContract() {
                this.contract_add_modal.show()
            },
            showOverview(id) {
                var $this = this;
                axios.post(this.data.contract_overview_link, {id: id}).then(function (value) {
                    $this.contents = value.data.contents;
                    $this.other_details = value.data.other;
                    $this.contract_overview_modal.show();
                });
            },
            viewImage(link) {
                this.image_path = link;
                this.contract_image_modal.show()
            }
        },
        watch: {
            'errors': function (value) {
                if (value.length > 0) {
                    alertify.error('Please fill all fields.');
                }
            }
        },
        mounted() {
            var $this = this;
            $this.contract_add_modal = new bootstrap.Modal(document.getElementById('contract-add-modal'), {
                keyboard: false
            });

            $this.contract_overview_modal = new bootstrap.Modal(document.getElementById('contract-overview-modal'), {
                keyboard: false
            });

            $this.contract_image_modal = new bootstrap.Modal(document.getElementById('contract-image-modal'), {
                keyboard: false
            });

            $this.dt = $('#contracts-table').DataTable({
                serverSide: true,
                ajax: {
                    url: $this.data.contract_table_link,
                    type: 'POST'
                },
                "order": [[0, "desc"]],
                "columns": [
                    {"data": 'created_at', "name": "created_at", "title": "Date Submitted"},
                    {
                        "data": function (value) {
                            var statuses = '';
                            $.each(value.audit, function (idx, item) {
                                statuses += '<span class="badge bg-primary">' + item.status + '</span>'
                            });

                            return statuses;
                        }, "name": "id", "title": "Status", bSortable: false
                    },
                    {
                        "data": function (value) {
                            return '<button type="button" class="btn-custom-id btn btn-sm btn-link">' +
                                value.custom_id + '</button>';
                        }, "name": "custom_id", "title": "Contract No."
                    },
                    {"data": 'type', "name": "type", "title": "Type"},
                ],
                drawCallback: function (settings) {
                    $('body .btn-custom-id').on('click', function () {
                        $this.showOverview($this.dt.row($(this).parent()).data().id);
                    });
                }
            });
        }
    }
</script>

<style scoped>

</style>
