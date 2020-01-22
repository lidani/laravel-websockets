<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Example Component</div>

          <div class="card-body">
            <!-- <button class="btn btn-outline-primary" @click="createUser">Criar usuário aleatoriamente</button> -->
            <button class="btn btn-outline-primary" @click="pusher">Teste pusher</button>

            <!-- <table class="table table-bordered my-2">
              <thead>
                <tr>
                  <td>
                    <strong>ID</strong>
                  </td>
                  <td>Nome</td>
                  <td>E-mail</td>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users" :key="user.id" @click="detail(user)">
                  <td>{{user.id}}</td>
                  <td>{{user.name}}</td>
                  <td>{{user.email}}</td>
                </tr>
              </tbody>
            </table> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  created() {
    console.log("created");
    window.Echo.channel('Testezinho').listen('EventTestezinho', e => console.log(e));
    window.Echo.channel("eventoTest").listen("EventoTest", e => {
      console.log("evento teste listen from Example component.vue", e);
      let i;
      const user = this.users.find((user, index) => {
        if (user.id === e.user.id) {
          i = index;
          return true;
        }
        return false;
      });
      if (!user) {
        this.users = this.users.slice().reverse();
        this.users.push(e.user);
        this.users = this.users.slice().reverse();
      } else {
        this.users.splice(i, 1, e.user);
      }
    });
  },
  mounted() {
    console.log("Component mounted.");
    axios
      .get("/api/users")
      .then(response => {
        this.users = response.data.slice().reverse();
      })
      .catch(e => console.error(e.response || e));
  },
  data() {
    return {
      users: []
    };
  },
  methods: {
    detail(user) {
      this.$router.push({ name: "detail", params: { user } });
    },
    pusher(){
        axios.post("/api/testpusher").then(r => console.log(r)).catch(e => console.error(e));
    },
    createUser() {
      axios
        .post("/api/user/create")
        .then(response => console.log("create user response:", response))
        .catch(e => console.error(e.response || e));
    }
  }
};
</script>
