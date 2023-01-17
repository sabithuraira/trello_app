<template>
    <div class="list">
        <h3 class="list-title">{{ dataColumn.title }}</h3>

        <ul class="list-items">
            <li v-for="data in dataColumn.listCard" :key="data.encId">
                {{ data.title }}
            </li>
        </ul>

        <button @click="showModal" class="add-card-btn btn">Add a card</button>

        <modal name="add-card-modal">
            <div class="modal-form" >
                <h1>Card Information</h1>

                <h2>Title: </h2>
                <input type="text" v-model="formTitle" /><br/><br/>

                <h2>Description: </h2>
                <textarea rows="5" cols="33" v-model="formDescription"></textarea><br/><br/>

                <button @click="saveCard(dataColumn.id)">Save</button> &nbsp; &nbsp;
                <button @click="hideModal">Close</button>
            </div>
        </modal>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'List',
        props: {
            propDataColumn: null,
        },
        data(){
            return {
                dataColumn: this.propDataColumn,
                formTitle: '',
                formDescription: '',
            }
        },
        methods: {
            getDatas(){
                const self = this;
                this.isLoading = true;
                return axios
                    .get('column/' + self.dataColumn.encId)
                    .then(({ data }) => {
                        if(data.status=="success") self.dataColumn = data.datas
                        else alert("Data not found!")

                        this.isLoading = false;
                    })
            },
            saveCard(column_id){
                const self = this;
                return axios.post('card' , {
                    title: self.formTitle,
                    description: self.formDescription,
                    column_id: column_id
                })
                .then(({ data }) => {
                    if(data.status=="success") self.getDatas();
                    else alert(data.data)

                    self.hideModal();
                });
            },
            showModal(){
                this.$modal.show('add-card-modal');
            },
            hideModal(){
                this.formTitle = "";
                this.formDescription = "";
                this.$modal.hide('add-card-modal');
            }
        },
        created(){
            axios.defaults.baseURL = this.$apiUrl
            axios.defaults.headers.common = {'Authorization': `Bearer ${this.$apiToken}`}
        },
    }
</script>

<style scoped>
.list {
    flex: 0 0 27rem;
    display: flex;
    flex-direction: column;
    background-color: #e2e4e6;
    max-height: calc(100vh - 11.8rem);
    border-radius: 0.3rem;
    margin-right: 1rem;
}

.list:last-of-type {
    margin-right: 0;
}

.list-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #333;
    padding: 1rem;
}

.list-items {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-content: start;
    padding: 0 0.6rem 0.5rem;
    overflow-y: auto;
}

.list-items::-webkit-scrollbar {
    width: 1.6rem;
}

.list-items::-webkit-scrollbar-thumb {
    background-color: #c4c9cc;
    border-right: 0.6rem solid #e2e4e6;
}

.list-items li {
    font-size: 1.4rem;
    font-weight: 400;
    line-height: 1.3;
    background-color: #fff;
    padding: 0.65rem 0.6rem;
    color: #4d4d4d;
    border-bottom: 0.1rem solid #ccc;
    border-radius: 0.3rem;
    margin-bottom: 0.6rem;
    word-wrap: break-word;
    cursor: pointer;
}

.list-items li:last-of-type {
    margin-bottom: 0;
}

.list-items li:hover {
    background-color: #eee;
}

.add-card-btn {
    display: block;
    font-size: 1.4rem;
    font-weight: 400;
    color: #838c91;
    padding: 1rem;
    text-align: left;
    cursor: pointer;
}

.add-card-btn:hover {
    background-color: #cdd2d4;
    color: #4d4d4d;
    text-decoration: underline;
}

.add-card-btn::after{
    content: '...';
}

</style>
