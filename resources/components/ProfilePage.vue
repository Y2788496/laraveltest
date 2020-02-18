<template>
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">User Profile</li>
            </ol>
        </nav>
        <div class="card" style="width: 18rem;">
            <img
                :src="user.avatar_url"
                class="card-img-top"
            >
            <div class="card-body">
                <h5 class="card-title">{{ user.username }}</h5>
                <p class="card-text">
                    ID: {{ user.id }}
                    <br>
                    <a :href="githubProfileUrl" target="_blank">Github Profile</a>
                </p>
                <button
                    class="btn btn-primary"
                    @click="toggleHideProfile"
                >
                    {{ textBtnHide }} profile
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ProfilePage',
        props: {
            userId: Number
        },
        data() {
            return {
                user: {}
            }
        },
        computed: {
            textBtnHide() {
                return !this.user.is_hide ? 'Hide' : 'Show';
            },
            githubProfileUrl() {
                return 'https://github.com/' + this.user.username;
            }
        },
        methods: {
            toggleHideProfile() {
                let isHide = !this.user.is_hide;

                axios
                    .post('/api/user/hide', {
                        id: this.user.id,
                        is_hide: isHide
                    })
                    .then(response => {
                        this.user.is_hide = isHide;
                    })
                    .catch(error => {
                        console.log(error.response);
                    });
            }
        },
        created() {
            axios
                .get('/api/user/' + this.userId)
                .then(response => {
                    this.user = response.data.data;
                })
                .catch(error => {
                    console.log(error.response);
                });
        }
    };
</script>

<style lang="scss" scoped>
    .breadcrumb, .form-check {
        margin-top: 15px;
    }

    .avatar {
        width: 50px;
    }
</style>
