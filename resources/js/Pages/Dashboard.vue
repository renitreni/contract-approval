<template>
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <div class="d-flex flex-column">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" aria-label="Text input with dropdown button"
                           v-model="cases.keyword" placeholder="Type In Keyword...">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Search Type: <b>{{ cases.drop_down }}</b>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" @click="cases.drop_down = 'Company'">Company</a></li>
                        <li><a class="dropdown-item" href="#" @click="cases.drop_down = 'Worker'">Worker</a></li>
                        <li><a class="dropdown-item" href="#" @click="cases.drop_down = 'Employer'">Employer</a></li>
                    </ul>
                    <button class="btn btn-primary" type="button" @click="searchCase">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap">
        <div v-for="item in case_results" class="mx-2 align-content-end">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Case No. {{ item.atnsia_no }}</h5>
                    <h6 class="card-subtitle mb-2">
                        <span class="badge bg-danger" v-if="item.status == 'suspended'">Suspended</span>
                        <span class="badge bg-warning" v-if="item.status == 'warning'">Warning</span>
                        <span class="badge bg-success" v-if="item.status == 'lifted'">Lifted</span>
                    </h6>
                    <h6 class="card-subtitle mb-2 text-muted">Company: {{ item.company.name }}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Employer: {{ item.employer.name }}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Worker: {{ item.worker.last_name }}, {{ item.worker.first_name }}</h6>
                    <p class="card-text">{{ item.complaint }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['data'],
    data() {
        return {
            keyword: '',
            cases: {
                keyword: '',
                drop_down: 'Company',
            },
            case_results : []
        };
    },
    methods: {
        searchContract() {
            var $this = this;
            axios.post(this.data.search_contract, {keyword: this.keyword}).then(function (value) {
            });
        },
        searchCase() {
            var $this = this;
            axios.post(this.data.search_cases, $this.cases).then(function (value) {
                $this.case_results = value.data;
            });
        }
    }
}
</script>
