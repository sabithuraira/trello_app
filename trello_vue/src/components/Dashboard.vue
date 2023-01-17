<template>
  <div>
        <section class="lists-container">
            <List v-for="data in data_list" :propDataColumn=data :key="'list-'+data.id" />
            <button @click="showModal" class="add-list-btn btn">Add a list</button>
        </section>
        <div id="loading" v-show="isLoading">
            <img id="loading-image" src="@/assets/loader.gif" alt="Loading..." />
        </div>

        <modal name="add-list-modal">
            <div class="modal-form" >
                <h1>List Information</h1>

                <h2>Title: </h2>
                <input type="text" v-model="formTitle" /><br/><br/>
                <button @click="saveList">Save</button> &nbsp; &nbsp;
                <button @click="hideModal">Close</button>
            </div>
        </modal>
  </div>
</template>

<script>
    import List from './List.vue';
    import axios from 'axios';

    export default {
        name: 'Dashboard',
        components: {
            List
        },
        props: {
            msg: String
        },
        data(){
            return {
                data_list: [],
                isLoading: true,
                formTitle: '',
            }
        },
        methods: {
            getDatas(){
                let self = this;
                this.isLoading = true;
                return axios
                    .get('column')
                    .then(({ data }) => {
                        if(data) self.data_list = data
                        else alert("Data not found!")

                        this.isLoading = false;
                    })
            },
            saveList(){
                let self = this;
                this.isLoading = true;

                return axios.post('column' , {
                    title: self.formTitle
                })
                .then(({ data }) => {
                    if(data.status=="success") self.getDatas();
                    else alert(data.data)

                    self.hideModal();
                    self.isLoading = false;
                });
            },
            showModal(){
                this.$modal.show('add-list-modal');
            },
            hideModal(){
                this.formTitle = "";
                this.$modal.hide('add-list-modal');
            }
        },
        created(){
            this.isLoading = false;
            axios.defaults.baseURL = this.$apiUrl
            axios.defaults.headers.common = {'Authorization': `Bearer ${this.$apiToken}`}
            this.getDatas()
        },
    }
</script>

<style scoped>
    .lists-container::-webkit-scrollbar {
        height: 2.4rem;
    }

    .lists-container::-webkit-scrollbar-thumb {
        background-color: #66a3c7;
        border: 0.8rem solid #0079bf;
        border-top-width: 0;
    }

    .lists-container {
        display: grid;
        grid-auto-columns: 27rem;
        grid-auto-flow: column;
        grid-column-gap: 1rem;
    }

    .lists-container {
        display: flex;
        align-items: start;
        padding: 0 0.8rem 0.8rem;
        overflow-x: auto;
        height: calc(100vh - 8.6rem);
    }

    .add-list-btn {
        flex: 0 0 27rem;
        display: block;
        font-size: 1.4rem;
        font-weight: 400;
        background-color: #006aa7;
        color: #a5cae0;
        padding: 1rem;
        border-radius: 0.3rem;
        cursor: pointer;
        transition: background-color 150ms;
        text-align: left;
    }

    .add-list-btn:hover {
        background-color: #005485;
    }

    .add-list-btn::after {
        content: '...';
    }

    #loading {
        position: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0.7;
        background-color: #fff;
        z-index: 99;
    }

    #loading-image {
        z-index: 100;
        height: 100px;
        width: 100px;
    }
</style>
