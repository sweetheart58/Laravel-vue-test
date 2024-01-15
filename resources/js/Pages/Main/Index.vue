<template>
  <Head title="Login" />
  <div class="flex items-center justify-center p-6 min-h-screen bg-indigo-100">
    <div class="w-full max-w-md">
      <logo class="block mx-auto w-full max-w-xs fill-white" height="50" />
      <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="sendUrl">
        <div class="px-10 py-12">
          <h1 class="text-center text-3xl font-bold">Welcome!</h1>
          <div class="mt-2 mx-auto w-24 border-b-2" />
          <text-input v-model="form.url" :error="form.errors.url" class="mt-10" label="URL" type="text" autofocus autocapitalize="off" />
          <div class="mt-8" />
          <a v-if="result" :href="`http://127.0.0.1:8000/redirect/?result=${result}`" target="_blank"><h1>{{ result }}</h1></a>
        </div>
        <div class="flex px-10 py-4 bg-gray-100 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Send</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
  import { Head } from '@inertiajs/inertia-vue3';
  import Logo from '@/Component/Logo';
  import TextInput from '@/Component/Input';
  import LoadingButton from '@/Component/Button';
  export default {
    props: ['result'],
    setup(props) {},
    components: {
      Head,
      LoadingButton,
      Logo,
      TextInput,
    },
    data() {
      return {
        form: this.$inertia.form({
          url: "example.com/testUrl",
        })
      }
    },
    methods: {
      sendUrl() {
        this.form.post('/sendUrl');
      },
    },
  }
</script>  