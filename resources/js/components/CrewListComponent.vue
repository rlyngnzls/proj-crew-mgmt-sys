<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-3 rounded-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6 d-flex justify-content-start align-items-center h-100">
                                <span class="text-uppercase fw-bolder fs-5">Crew List</span>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6 text-end">
                                <!-- <span class="text-uppercase fw-bolder fs-5">Crew List</span> -->
                                 <button class="btn btn-mint btn-sm" @click="createCrewModalTrigger = true">
                                    <i class="fa-duotone fa-solid fa-user-plus fa-fw me-1"></i> Add Crew
                                 </button>
                                 <button class="btn btn-secondary btn-sm" @click="filterCrewModalTrigger = true">
                                    <i class="fa-duotone fa-solid fa-filter-list fa-fw me-1"></i> Filter by Rank
                                 </button>
                                
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-2 pe-1">
                                        <b-form-select v-model="perPage" :options="$page_options" required class="form-control"></b-form-select>
                                    </div>
                                    <div class="col-md-10 d-flex justify-content-start align-items-center ps-1">
                                        <span class="text-dark">entries per page</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <b-form-input type="search" placeholder="Search Firstname / Lastname / Rank" aria-label="Search"
                                v-model="search"></b-form-input>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <b-table :bordered=true :hover=true :items="searchCrew" :fields="fields" responsive show-empty
                                    :per-page="perPage" :current-page="currentPage" :busy="loading_table" id="tableCrew">
                                    <template #empty="scope">
                                        <div class="container-fluid bg-light p-3 text-center border border-lg rounded">
                                            <h5 class="text-muted pt-2 pb-1">No Records Found.</h5>
                                        </div>
                                    </template>
                                    <template #table-busy>
                                        <div class="container-fluid bg-light p-3 text-center border border-lg rounded">
                                            <i class="fa-duotone fa-spinner fa-spin-pulse fa-lg"></i>
                                            <h5 class="text-muted pt-2 pb-1">Loading...</h5>
                                        </div>
                                    </template>
                                    <template #cell(first_name)="row">
                                        <div class="d-flex justify-content-start align-items-center h-100 my-2">
                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.first_name }}</span>
                                        </div>
                                    </template>
                                    <template #cell(middle_name)="row">
                                        <div class="d-flex justify-content-start align-items-center h-100 my-2">
                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.middle_name }}</span>
                                        </div>
                                    </template>
                                    <template #cell(last_name)="row">
                                        <div class="d-flex justify-content-start align-items-center h-100 my-2">
                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.last_name }}</span>
                                        </div>
                                    </template>
                                    <template #cell(email)="row">
                                        <div class="d-flex justify-content-start align-items-center h-100 my-2">
                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.email }}</span>
                                        </div>
                                    </template>
                                    <template #cell(address)="row">
                                        <div class="d-flex justify-content-start align-items-center h-100 my-2">
                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.address }}</span>
                                        </div>
                                    </template>
                                    <template #cell(birthdate)="row">
                                        <div class="d-flex justify-content-center align-items-center h-100 my-2">
                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.birthdate }}</span>
                                        </div>
                                    </template>
                                    <template #cell(age)="row">
                                        <div class="d-flex justify-content-center align-items-center h-100 my-2">
                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.age }}</span>
                                        </div>
                                    </template>
                                    <template #cell(height)="row">
                                        <div class="d-flex justify-content-center align-items-center h-100 my-2">
                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.height }}</span>
                                        </div>
                                    </template>
                                    <template #cell(weight)="row">
                                        <div class="d-flex justify-content-center align-items-center h-100 my-2">
                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.weight }}</span>
                                        </div>
                                    </template>
                                    <template #cell(rank)="row">
                                        <div class="d-flex justify-content-center align-items-center h-100 my-2">
                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.rank }} - {{ row.item.alias }}</span>
                                        </div>
                                    </template>
                                    <template #cell(bmi)="row">
                                        <div class="d-flex justify-content-center align-items-center h-100 my-2">
                                            <span v-if="(row.item.height == '0') && (row.item.weight == '0')" class="text-wrap" style="font-size: 13px;">N/A</span>
                                            <span v-else-if="row.item.height && row.item.weight" class="text-wrap" style="font-size: 13px;">{{ (row.item.weight/((row.item.height/100)*(row.item.height/100))).toFixed(2) }}</span>
                                            <span v-else class="text-wrap" style="font-size: 13px;">N/A</span>
                                        </div>
                                    </template>
                                    <template #cell(actions)="row">
                                        <div class="text-center">
                                            <button class="btn btn-sm btn-primary" @click="viewCrewModal(row.item)"><i class="fa-duotone fa-solid fa-pen-to-square fa-fw"></i></button>
                                            <a class="btn btn-sm btn-secondary" :href="'/documents/'+row.item.crew_id"><i class="fa-duotone fa-solid fa-folder-open fa-fw"></i></a>
                                            <button class="btn btn-sm btn-amaranth" @click="removeCrewData(row.item)"><i class="fa-duotone fa-solid fa-user-xmark fa-fw"></i></button>
                                        </div>
                                    </template>
                                </b-table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-start align-items-center h-100">
                                <b-pagination v-model="currentPage" :total-rows="items.length" :per-page="perPage"
                                    aria-controls="tableCrew" size="sm"></b-pagination>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end align-items-center h-100">
                                <span class="text-uppercase">{{ items.length }} item(s).</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Crew Modal -->
        <b-modal v-model="createCrewModalTrigger" centered size="xl" hide-header hide-header-close no-close-on-backdrop
            no-close-on-esc hide-footer>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-start align-items-center h-100">
                        <span class="text-uppercase fw-bolder fs-5">Crew Information</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="">
                            <label for="first_name" class="form-label">Firstname</label>
                            <input type="text" class="form-control" id="first_name" placeholder="Ex. Juan" v-model="first_name" onkeypress="return /[a-z\s ñ Ñ -]/i.test(event.key)">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="">
                            <label for="last_name" class="form-label">Lastname</label>
                            <input type="text" class="form-control" id="last_name" placeholder="Ex. Dela Cruz" v-model="last_name" onkeypress="return /[a-z\s ñ Ñ -]/i.test(event.key)">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="">
                            <label for="middle_name" class="form-label">Middlename</label>
                            <input type="text" class="form-control" id="middle_name" placeholder="(optional)" v-model="middle_name" onkeypress="return /[a-z\s ñ Ñ -]/i.test(event.key)">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-8 col-lg-8">
                        <div class="">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="Ex. 1164 Pres Quirino Avenue 1000, Manila" v-model="address">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Ex. jdelacruz@example.com" v-model="email">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="">
                            <label for="birthdate" class="form-label">Birthdate</label>
                            <input type="date" class="form-control" id="birthdate" v-model="birthdate" @input="calculateAge">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2 col-lg-2">
                        <div class="">
                            <label for="age" class="form-label">Age</label>
                            <input type="text" class="form-control" id="age" v-model="age" readonly>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7 col-lg-7">
                        <div class="">
                            <label for="rank" class="form-label">Rank</label>
                            <select class="form-select" v-model="rank">
                                <option selected value="null" disabled>-- Please select rank --</option>
                                <option :value="data.code" v-for="(data, index) in crew_ranks" :key="index">({{ data.code }}) - {{data.rank_name}}</option>
                            </select>
                            <!-- <input type="text" class="form-control" id="rank" placeholder="(optional)" v-model="rank"> -->
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="">
                            <label for="height" class="form-label">Height(cm)</label>
                            <input type="number" class="form-control" id="height" placeholder="(cm) in centimeters" v-model.number="height" @input="calculateBMI">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="">
                            <label for="weight" class="form-label">Weight(kg)</label>
                            <input type="number" class="form-control" id="weight" placeholder="(kg) in kilograms" v-model.number="weight" @input="calculateBMI">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="">
                            <label for="bmi" class="form-label">BMI</label>
                            <input type="text" class="form-control" id="bmi" v-model="bmi" readonly>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
                        <button type="button" class="btn btn-primary" @click="submitCrewData()">Submit</button>
                    </div>
                </div>
        </b-modal>
        <!-- End Create Crew Modal -->

        <!-- View Crew Modal -->
        <b-modal v-model="viewCrewModalTrigger" centered size="xl" hide-header hide-header-close no-close-on-backdrop
            no-close-on-esc hide-footer>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-start align-items-center h-100">
                    <span class="text-uppercase fw-bolder fs-5">Crew Information</span>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="">
                        <label for="first_name" class="form-label">Firstname</label>
                        <input type="text" class="form-control" id="first_name" placeholder="Ex. Juan" v-model="first_name">
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="">
                        <label for="last_name" class="form-label">Lastname</label>
                        <input type="text" class="form-control" id="last_name" placeholder="Ex. Dela Cruz" v-model="last_name">
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="">
                        <label for="middle_name" class="form-label">Middlename</label>
                        <input type="text" class="form-control" id="middle_name" placeholder="(optional)" v-model="middle_name">
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <div class="">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="Ex. 1164 Pres Quirino Avenue 1000, Manila" v-model="address">
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" placeholder="Ex. jdelacruz@example.com" v-model="email">
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <div class="">
                        <label for="birthdate" class="form-label">Birthdate</label>
                        <input type="date" class="form-control" id="birthdate" v-model="birthdate" @input="calculateAge">
                    </div>
                </div>
                <div class="col-sm-12 col-md-2 col-lg-2">
                    <div class="">
                        <label for="age" class="form-label">Age</label>
                        <input type="text" class="form-control" id="age" v-model="age" readonly>
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 col-lg-7">
                    <div class="">
                        <label for="rank" class="form-label">Rank</label>
                        <select class="form-select" v-model="rank">
                            <option selected value="null" disabled>-- Please select rank --</option>
                            <option :value="data.code" v-for="(data, index) in crew_ranks" :key="index">({{ data.code }}) - {{data.rank_name}}</option>
                        </select>
                        <!-- <input type="text" class="form-control" id="rank" placeholder="(optional)" v-model="rank"> -->
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="">
                        <label for="height" class="form-label">Height(cm)</label>
                        <input type="number" class="form-control" id="height" placeholder="(cm) in centimeters" v-model.number="height" @input="calculateBMI">
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="">
                        <label for="weight" class="form-label">Weight(kg)</label>
                        <input type="number" class="form-control" id="weight" placeholder="(kg) in kilograms" v-model.number="weight" @input="calculateBMI">
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="">
                        <label for="bmi" class="form-label">BMI</label>
                        <input type="text" class="form-control" id="bmi" v-model="bmi" readonly>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
                    <button type="button" class="btn btn-primary" @click="saveCrewData()">Save</button>
                </div>
            </div>
        </b-modal>
        <!-- End View Crew Modal -->

        <!-- Filter Crew Modal -->
        <b-modal v-model="filterCrewModalTrigger" centered size="sm" hide-header hide-header-close no-close-on-backdrop
            no-close-on-esc hide-footer>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-start align-items-center h-100">
                    <span class="text-uppercase fw-bolder fs-5">Filter by Rank</span>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="">
                        <label for="rank" class="form-label">Rank</label>
                        <select class="form-select" v-model="filterRank">
                            <option value="null" disabled>-- Please select rank --</option>
                            <option selected value="All">All Ranks</option>
                            <option :value="data.code" v-for="(data, index) in crew_ranks" :key="index">({{ data.code }}) - {{data.rank_name}}</option>
                        </select>
                        <!-- <input type="text" class="form-control" id="rank" placeholder="(optional)" v-model="rank"> -->
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
                    <button type="button" class="btn btn-primary" @click="filterCrewData()">Filter</button>
                </div>
            </div>
        </b-modal>
        <!-- End Filter Crew Modal -->

    </div>
</template>

<script>
import { Modal } from 'bootstrap';
    export default {
        mounted() {
            this.getCrewList();
            this.getCrewRanks();
        },
        data() {
            return {
                Toast : this.$swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', this.$swal.stopTimer)
                        toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                    }
                }),
                
                crew_list: [],
                crew_ranks: [],
                first_name: null,
                last_name: null,
                middle_name: null,
                address: null,
                email: null,
                birthdate: null,
                age: null,
                rank: null,
                height: 0,
                weight: 0,
                bmi: 0,
                crew_id: null,

                items: [],
                fields: [
                    { key: 'first_name', label: 'Firstname', thStyle:  { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'middle_name', label: 'Middlename', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'last_name', label: 'Lastname', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'email', label: 'Email', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'address', label: 'Address', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'birthdate', label: 'Birthdate', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'age', label: 'Age', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'rank', label: 'Rank', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'height', label: 'Height', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'weight', label: 'Weight', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'bmi', label: 'BMI', thStyle: { fontSize: '13px' }, thClass: 'text-center text-uppercase'},
                    { key: 'actions', label: 'Actions', thStyle: { fontSize: '13px' }, thClass: 'text-center text-uppercase'},
                ],
                search: null,
                perPage: 5,
                currentPage: 1,
                loading_table: false,
                filterRank: 'All',

                viewCrewModalTrigger: false,
                createCrewModalTrigger: false,
                filterCrewModalTrigger: false,
                };
        },
        computed: {
            searchCrew() {
            return this.search
                ? this.items.filter(item =>
                    item.first_name.toLowerCase().includes(this.search.toLowerCase()) ||
                    item.last_name.toLowerCase().includes(this.search.toLowerCase()) ||
                    item.middle_name.toLowerCase().includes(this.search.toLowerCase()) ||
                    item.rank.toLowerCase().includes(this.search.toLowerCase()))
                : this.items;
            // item.date.toLowerCase().includes(this.search.toLowerCase()))
        },

        },
        methods: {
            getCrewList(){
                axios.post('/get/crew/list', {
                    filterRank: this.filterRank,
                }).then((response) => {
                    this.items = response.data;
                })
            },

            getCrewRanks(){
                axios.get('/get/crew/ranks')
                .then((response) => {
                    this.crew_ranks = response.data;
                })
            },

            getInput(){
                console.log(this.rank)
            },

            calculateAge() {
                if (!this.birthdate) {
                    this.age = null;
                    return;
                }

                const birthdate = new Date(this.birthdate);

                if (isNaN(birthdate.getTime())) {
                    this.age = null;
                    return;
                }

                const currentDate = new Date();
                let age = currentDate.getFullYear() - birthdate.getFullYear();

                if (
                    currentDate.getMonth() < birthdate.getMonth() ||
                    (currentDate.getMonth() === birthdate.getMonth() &&
                    currentDate.getDate() < birthdate.getDate())
                ) {
                    age--;
                }

                this.age = age;
            },

            calculateBMI() {
                if (this.height && this.weight) {
                    console.log(this.height)
                    const heightInMeters = parseFloat(this.height)/100;
                    const weightInKilograms = parseFloat(this.weight);

                    if (heightInMeters > 0 && weightInKilograms > 0) {
                    const calculatedBMI = weightInKilograms / (heightInMeters * heightInMeters);
                    this.bmi = calculatedBMI.toFixed(2); // Round to 2 decimal places
                    } else {
                    this.bmi = null; // Reset BMI if inputs are invalid
                    }
                } else {
                    this.bmi = null; // Reset BMI if either height or weight is empty
                }
            },

            submitCrewData(){
                if(!this.first_name){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Firstname is required!"
                    });
                }
                else if(!this.last_name){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Lastname is required!"
                    });
                }
                else if(!this.address){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Address is required!"
                    });
                }
                else if(!this.email){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Email is required!"
                    });
                }
                else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email)) {
                    this.Toast.fire({
                        icon: "error",
                        title: "Invalid Email",
                        html: "Please enter a valid email address!"
                    });
                }
                else if(!this.birthdate){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Birthdate is required!"
                    });
                }
                else if(this.age <= 15){
                    this.Toast.fire({
                        icon: "error",
                        title: "Age Restriction",
                        html: "The age restriction was not met!"
                    });
                }
                else if(!this.rank){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Please select crew rank!"
                    });
                }
                else{
                    if(!this.middle_name){
                        this.middle_name = "N/A";
                    }
                    if(!this.height){
                        this.height = 0;
                    }
                    if(!this.weight){
                        this.weight = 0;
                    }

                    this.$swal.fire({
                        title: 'Submit Crew Data',
                        html: "Are you sure you want to add this crew to the list?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3cba92',
                        cancelButtonColor: '#dc3545',
                        confirmButtonText: 'Proceed'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.post('/insert/crew/data', {
                                first_name: this.first_name,
                                last_name: this.last_name,
                                middle_name: this.middle_name,
                                address: this.address,
                                email: this.email,
                                birthdate: this.birthdate,
                                age: this.age,
                                rank: this.rank,
                                height: this.height,
                                weight: this.weight,
                            }).then((response) => {
                                console.log(response.data);
                                this.getCrewList();
                                this.closeModal();
                                this.Toast.fire({
                                    icon: 'success',
                                    title: 'Crew Data Inserted!',
                                    html: 'Crew information created successfully.',
                                });
                            })
                        }
                    })
                }
                
                
            },

            saveCrewData(){
                if(!this.first_name){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Firstname is required!"
                    });
                }
                else if(!this.last_name){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Lastname is required!"
                    });
                }
                else if(!this.address){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Address is required!"
                    });
                }
                else if(!this.email){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Email is required!"
                    });
                }
                else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email)) {
                    this.Toast.fire({
                        icon: "error",
                        title: "Invalid Email",
                        html: "Please enter a valid email address!"
                    });
                }
                else if(!this.birthdate){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Birthdate is required!"
                    });
                }
                else if(this.age <= 15){
                    this.Toast.fire({
                        icon: "error",
                        title: "Age Restriction",
                        html: "The age restriction was not met!"
                    });
                }
                else if(!this.rank){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Please select crew rank!"
                    });
                }
                else{
                    if(!this.middle_name){
                        this.middle_name = "N/A";
                    }
                    if(!this.height){
                        this.height = 0;
                    }
                    if(!this.weight){
                        this.weight = 0;
                    }

                    this.$swal.fire({
                        title: 'Update Crew Data',
                        html: "Are you sure you want to update this crew information?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3cba92',
                        cancelButtonColor: '#dc3545',
                        confirmButtonText: 'Proceed'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.post('/save/crew/data', {
                                crew_id: this.crew_id,
                                first_name: this.first_name,
                                last_name: this.last_name,
                                middle_name: this.middle_name,
                                address: this.address,
                                email: this.email,
                                birthdate: this.birthdate,
                                age: this.age,
                                rank: this.rank,
                                height: this.height,
                                weight: this.weight,
                            }).then((response) => {
                                this.getCrewList();
                                this.closeModal();
                                this.Toast.fire({
                                    icon: 'success',
                                    title: 'Crew Data Updated!',
                                    html: 'Crew information updated successfully.',
                                });
                            })
                        }
                    })
                }                
            },

            removeCrewData(data){
                this.$swal.fire({
                    title: 'Remove Crew',
                    html: "Are you sure you want to remove this crew from the list?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3cba92',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Proceed'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post('/remove/crew/data', {
                            id: data.id,
                        }).then((response) => {
                            this.getCrewList();
                            this.Toast.fire({
                                icon: 'success',
                                title: 'Crew Data Removed!',
                                html: 'Crew information removed successfully.',
                            });
                        })
                    }
                })
                
            },

            filterCrewData(){
                this.getCrewList();
                this.closeModal();
            },

            viewCrewModal(data){
                this.viewCrewModalTrigger = true;
                this.crew_id = data.crew_id;
                this.first_name = data.first_name;
                this.last_name = data.last_name;
                this.middle_name = data.middle_name;
                this.address = data.address;
                this.email = data.email;
                this.birthdate = data.birthdate;
                this.age = data.age;
                this.rank = data.rank;
                this.height = data.height;
                this.weight = data.weight;
                this.calculateBMI();
            },

            closeModal(){
                this.createCrewModalTrigger = false;
                this.viewCrewModalTrigger = false;
                this.filterCrewModalTrigger = false;

                this.first_name = null;
                this.last_name = null;
                this.middle_name = null;
                this.address = null;
                this.email = null;
                this.birthdate = null;
                this.age = null;
                this.rank = null;
                this.height = 0;
                this.weight = 0;
                this.bmi = 0;
                this.crew_id = null;
            },
        },
    }
</script>
