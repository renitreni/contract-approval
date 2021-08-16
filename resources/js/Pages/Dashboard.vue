<template>
    <div>
        <div class="d-flex flex-column">
            <div>
                <label>Contract Checker</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Type in Contract No."
                           aria-label="Recipient's username" aria-describedby="button-addon2" v-model="keyword">
                    <button class="btn btn-primary" type="button" id="button-addon2" @click="search">Search</button>
                </div>
            </div>
            <div>
                <div class="card" v-if="overview.type">
                    <div class="card-body">
                        <div class="d-flex flex-column">
                            <div>
                                <h2>{{ overview.type }}</h2>
                            </div>
                            <div>
                                <span>Submitted By: <strong>{{ overview.creator.name }} ({{ overview.creator.email}})</strong></span>
                            </div>
                            <div>
                                <span>Status:
                                    <strong v-for="item in overview.audit">
                                        <span class="badge bg-primary">{{ item.status }}</span>
                                    </strong>
                                </span>
                            </div>
                        </div>
                    </div>
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
                keyword: 'CA210816260208',
                overview: {}
            };
        },
        methods: {
            search() {
                var $this = this;
                axios.post(this.data.search_contract, {keyword: this.keyword}).then(function (value) {
                    $this.overview = value.data;
                });
            }
        }
    }
</script>
