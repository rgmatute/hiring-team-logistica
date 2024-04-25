import { Component, Inject, Vue } from 'vue-property-decorator';

@Component
export default class NavVerticalAdmin extends Vue {
  public show = false;
  public logout(): void {
    localStorage.removeItem('jhi-authenticationToken');
    sessionStorage.removeItem('jhi-authenticationToken');
    sessionStorage.removeItem('rol');
    this.$store.commit('logout');
    this.$router.push('/');
  }
}
