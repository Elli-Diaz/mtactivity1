<template>
    <div class="container-fluid pt-3">
        <div class="header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-link" href="/">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Region
                    </li>
                </ol>
            </nav>
        </div>
        <div class="card p-4">
            <h3>Region</h3>
            <div class="row">
                <div class="col-md-12 mb-2">
                    <button class="btn btn-primary" v-on:click="showModal">
                        + Create New Region
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

            <!-- Modal: -->
            <div class="modal" id="create-region">
                <div class="modal-dialog modal-dialog-centered bd-example">
                    <div class="modal-content">
                        <div class="text-center modal-header">
                            <p v-if="isEditData == false" class="modal-title">
                                Create Region
                            </p>

                            <p v-else class="modal-title">Edit Region</p>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Region Name:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="name"
                                    placeholder="Input name here"
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
        <div class="vld-parent" style="z-index: 999999 !important">
            <loading
                :active="isLoading"
                :can-cancel="false"
                :is-full-page="fullPage"
            >
            </loading>
        </div>
    </div>
</template>
<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
// import TestComponent from "../TestComponent.vue";
export default {
    components: {
        Loading,
    },
    data() {
        return {
            name: "",
            id: "",
            errors: "",
            isEditData: false,
            isLoading: false,
            fullPage: true,
            dataTable: [],
            columns: ["id", "name", "actions"],
            options: {
                headings: {
                    id: "ID",
                    name: "Region",
                    actions: "Actions",
                },
                filterable: true,
                sortable: ["id", "name"],
            },
        };
    },
    methods: {
        init() {
            this.name = "";
            this.errors = [];
        },
        show() {
            axios.get("region/show").then((response) => {
                this.dataTable = response.data.data;
            });
        },
        showModal() {
            this.isEditData = false;
            this.init();
            $("#create-region").modal("show");
        },
        closeModal() {
            $("#create-region").modal("hide");
        },
        store() {
            this.isLoading = true;
            axios
                .post("region/store", {
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
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        editData(data) {
            this.isEditData = true;
            this.id = data.row.id;
            this.name = data.row.name;
            $("#create-region").modal("show");
        },
        updateData() {
            axios.put("/region/update/" + this.id, {
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
                axios.get('region/destroy/' + data.row.id
            ).then((response) => {
                    this.$fire({
                        title: "Success",
                        text: response.data.message,
                        type: "success",
                        timer: 3000,
                    })
                   
                    this.show();
                }).catch((error) => {
                    if (error.response.status = 500){
                        this.$fire({
                        title: "Error",
                        text: "Internal Server Error",
                        type: "warning",
                        timer: 3000,
                    })
                    }
                    
                });
            }
        }
    },
    mounted() {
        this.show();
        this.init();
    },
};
</script>
<style>
.breadcrumb {
    background-color: #f4f6f9;
}
.breadcrumb-link {
    color: #000;
    font-weight: bold;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #28a745;
    font-weight: bold;
}
.modal-header {
    font-weight: bold;
    font-size: 24px;
    background-color: #28a745;
    color: #ffffff;
    padding: 10px 0px 0px 10px;
}
</style>
