// LikeComponent.vue

<template>
    <div class="container">
        <div class="row justify-content-center mt-1">
            <div class="col-md-12">
                <div>
                    <button>
                        いいね解除
                    </button>
                    <button>
                        いいね
                    </button>
                    <p>いいね数：</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Like Component mounted.')
        }
    }
</script>