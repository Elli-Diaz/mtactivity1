<template>
    <div class="container-fluid pt-3">
        <div class="header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-link" href="/">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        City
                    </li>
                </ol>
            </nav>
        </div>
        <div class="card p-4">
            <h3>City</h3>
            <div class="row">
                <div class="col-md-12 mb-2">
                    <button class="btn btn-primary" v-on:click="showModal">
                        + Create New City
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

            <div class="modal" id="create-city">
                <div class="modal-dialog modal-dialog-centered bd-example">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p v-if="isEditData == false" class="modal-title">
                                Create City
                            </p>
                            <p v-else class="modal-title">Edit City</p>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="region_id">Region:</label>
                                <select
                                    id="region_id"
                                    class="form-control"
                                    v-model="region_id"
                                    v-on:change="getProvincesByRegion(region_id)"
                                >
                                    <option
                                        v-for="region in regions"
                                        :value="region.id"
                                    >   
                                        {{ region.name }}
                                    </option>
                                </select>
                                <label for="province_id">Province:</label>
                                <select
                                    id="province_id"
                                    class="form-control"
                                    v-model="province_id"
                                    :class="{
                                        'border border-danger': errors.province_id,
                                    }"
                                >
                                    <option 
                                        v-for="province in provinces"
                                        :value="province.id"
                                    >
                                        {{ province.name }}
                                    </option>
                                </select>
                                <p class="text-danger" v-if="errors.province_id">
                                    {{ errors.province_id[0] }}
                                </p>

                                <label for="name">City:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="name"
                                    placeholder="Input city name here"
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
    props: ["regions"],
    data() {
        return {
            id: "",
            region_id: "",
            province_id: "",
            provinces: [],
            name: "",
            errors: "",
            isEditData: false,
            dataTable: [],
            columns: ["id", "region_name", "province_name", "name", "actions"],
            options: {
                headings: {
                    id: "ID",
                    region_name: "Region",
                    province_name: "Province",
                    name: "City",
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
            this.province_id = "";
            this.provinces = [];
            this.errors = [];
        },
        show() {
            axios.get("city/show").then(response => {
                this.dataTable = response.data.city;
            });
        },
        showModal() {
            this.isEditData = false;
            this.init();
            $("#create-city").modal("show");
        },
        closeModal() {
            this.init();
            $("#create-city").modal("hide");
        },
        store() {
            axios
                .post("city/store", {
                    province_id: this.province_id,
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
        getProvincesByRegion(region_id){
            axios.get('city/getProvincesByRegion/' + this.region_id).then(response =>{
                this.provinces = response.data.province;
                console.log(response.data.province)
            });
        },
        editData(data) {
            this.isEditData = true;
            this.id = data.row.id;
            axios.get('city/edit/'+ this.id).then(response=>{
                this.region_id = response.data.data.province.region.id;
                this.getProvincesByRegion(this.region_id);
                this.province_id = response.data.data.province_id;
                this.name = data.row.name;
            });
            $("#create-city").modal("show");
        },
        updateData() {
            axios.put("/city/update/" + this.id, {
                region_id: this.region_id,
                province_id: this.province_id,
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
                axios.get('city/destroy/' + data.row.id
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