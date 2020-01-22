<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card" v-if="user">
          <div class="card-header">Detalhe do usuario {{user.name}}</div>

          <div class="card-body">
            <table class="table table-bordered my-2">
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
                <tr>
                  <td>{{user.id}}</td>
                  <td @dblclick="dblclick">{{user.name}}</td>
                  <td>{{user.email}}</td>
                </tr>
              </tbody>
            </table>
            <input v-if="editing" class="input-group" v-model="newName" placeholder="Novo nome" />
            <button v-if="editing" @click="save">Salvar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: this.$route.params.user,
      editing: false,
      newName: ""
    };
  },
  created() {
    window.Echo.channel("change-" + this.user.id).listen("Change", e => {
      console.log("evento changed", e);
      this.user = e.user;
    });
  },
  methods: {
    save() {
      axios
        .post("/api/user/" + this.user.id, {
          id: this.user.id,
          email: this.user.email,
          name: this.newName
        })
        .then(r => console.log(r))
        .catch(e => console.error(e.response || e));
    },
    dblclick() {
      this.editing = true;
    }
  }
};
</script>
