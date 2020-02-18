<template>
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home Page</li>
            </ol>
        </nav>
        <form class="col-lg-6 col-md-6">
            <div class="form-group">
                <label for="searchInput">Search by github login</label>
                <input
                    v-model="searchValue"
                    type="text"
                    class="form-control"
                    id="searchInput"
                    placeholder="Enter github login"
                    @keydown.enter.prevent="search"
                >
            </div>
            <div v-if="showAlert"
                 class="form-group alert alert-warning alert-dismissible fade show"
                 role="alert"
            >
                {{ msgAlert }}
            </div>
            <button
                type="button"
                class="btn btn-primary btn-center"
                @click.prevent="search"
            >
                Search
            </button>
        </form>
        <div class="form-group form-check">
            <input
                type="checkbox"
                class="form-check-input"
                id="notHideCheck"
                v-model="showNotAll"
            >
            <label class="form-check-label" for="notHideCheck">
                Do not show hidden users
            </label>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">User Name</th>
                <th scope="col">Avatar</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in users">
                <th scope="row">{{ item.id }}</th>
                <td>
                    <a
                        :href="profileLink(item.id)"
                    >
                        {{ item.username }}
                    </a>
                </td>
                <td>
                    <img
                        class="rounded avatar"
                        :src="item.avatar_url"
                    >
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: 'HomePage',
        data() {
            return {
                searchValue: '',
                users: [],
                showAll: false,
                showAlert: false,
                msgAlert: ''
            }
        },
        computed: {
            showNotAll: {
                get() {
                    return !this.showAll;
                },
                set(val) {
                    this.showAll = !val;
                    this.getUsers();
                }
            }
        },
        methods: {
            search() {
                this.showAlert = false;
                this.msgAlert = '';

                if (this.searchValue.length) {
                    axios
                        .post('/api/search', {login: this.searchValue})
                        .then(response => {
                            this.users.splice(0, 0, response.data.data);
                            this.searchValue = '';
                        })
                        .catch(error => {
                            for (let item in error.response.data.errors) {
                                this.msgAlert += error.response.data.errors[item].join(' ');
                            }

                            this.showAlert = true;
                        });
                }
            },
            profileLink(id) {
                return '/profile/' + id;
            },
            getUsers() {
                let $url = '/api/users';

                if (this.showAll) {
                    $url += '/all';
                }

                axios
                    .get($url)
                    .then(response => {
                        this.users = response.data.data;
                    })
                    .catch(error => {
                        console.log(error.response);
                    });
            }
        },
        created() {
            this.getUsers();
        }
    };
</script>

<style lang="scss" scoped>
    .breadcrumb, .table, .form-check {
        margin-top: 15px;
    }

    .avatar {
        width: 50px;
    }
</style>
