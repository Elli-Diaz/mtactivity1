<template>
    <div class="container-fluid pt-3">
        <div class="header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-link" href="/">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Province
                    </li>
                </ol>
            </nav>
        </div>
        <div class="card p-4">
            <h3>Province</h3>
            <div class="row">
                <div class="col-md-12 mb-2">
                    <button class="btn btn-primary" v-on:click="showModal">
                        + Create New Province
                    </button>
                </div>
            </div>
            <v-client-table
                :data="dataTable"
                :columns="columns"
                :options="options"
            >
            <template slot="actions" slot-scope="row">
                    <button
                        class="btn btn-secondary"
                        v-on:click="editData(row)"
                    >
                        Edit
                    </button>
                    <button class="btn btn-danger" v-on:click="destroyData(row)">Delete</button>
                </template>
            </v-client-table>

            <div class="modal" id="create-province">
                <div class="modal-dialog modal-dialog-centered bd-example">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p v-if="isEditData == false" class="modal-title">
                                Create Province
                            </p>
                            <p v-else class="modal-title">Edit Province</p>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="region_id">Region:</label>
                                <select
                                    id="region_id"
                                    class="form-control"
                                    v-model="region_id"
                                >
                                    <option
                                        v-for="region in region"
                                        :value="region.id"
                                    >
                                        {{ region.name }}
                                    </option>
                                </select>

                                <label for="name">Province:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="name"
                                    placeholder="Input province name here"
                                    :class="{
                                        'border border-danger': errors.name,
                                    }"
                                />
                                <p class="text-danger" v-if="errors.name">
                                    {{ errors.name[0] }}
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                class="btn btn-outline-danger"
                                v-on:click="closeModal"
                            >
                                Cancel
                            </button>
                            <button
                                class="btn btn-primary"
                                v-on:click="store"
                                v-if="!isEditData"
                            >
                                Save
                            </button>
                            <button
                                class="btn btn-primary"
                                v-on:click="updateData"
                                v-else
                            >
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["region"],
    data() {
        return {
            id: "",
            region_id: "",
            name: "",
            errors: "",
            isEditData: false,
            dataTable: [],
            columns: ["id", "region_name", "name", "actions"],
            options: {
                headings: {
                    id: "ID",
                    region_name: "Region",
                    name: "Province",
                    actions: "Actions",
                },
                filterable: true,
                sortable: ["id", "name"],
            },
        };
    },
    methods: {
        init(){
            this.name = "";
            this.region_id = "";
            this.errors = [];
        },
        show() {
            axios.get("province/show").then(response => {
                console.log(response)
                this.dataTable = response.data.data;

            });
        },
        showModal() {
            this.isEditData = false;
            this.init();
            $("#create-province").modal("show");
        },
        closeModal() {
            $("#create-province").modal("hide");
        },
        store() {
            axios
                .post("province/store", {
                    region_id: this.region_id,
                    name: this.name,
                })
                .then((response) => {
                    this.$fire({
                        title: "Success",
                        text: response.data.message,
                        type: "success",
                        timer: 3000,
                    });
                    this.show();
                    this.closeModal();
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
        editData(data) {
            this.isEditData = true;
            this.id = data.row.id;
            this.region_id = data.row.region_id;
            this.name = data.row.name;
            $("#create-province").modal("show");
        },
        updateData() {
            axios.put("/province/update/" + this.id, {
                region_id: this.region_id,
                name: this.name,
            })
                .then((response) => {
                    this.$fire({
                        title: "Success",
                        text: response.data.message,
                        type: "success",
                        timer: 3000,
                    });
                    this.show();
                    this.closeModal();
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    console.log(this.errors.name);
                });
        },
        destroyData(data){
            if(confirm('Are you sure you want to delete this data?')){
                axios.get('province/destroy/' + data.row.id
            ).then((response) => {
                    this.$fire({
                        title: "Success",
                        text: response.data.message,
                        type: "success",
                        timer: 3000,
                    });
                    this.show();
                })
            }
        }
    },
    mounted(){
        this.show()
    }
};
</script>
