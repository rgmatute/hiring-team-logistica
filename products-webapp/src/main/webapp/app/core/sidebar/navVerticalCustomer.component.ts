import { Component, Inject, Vue } from 'vue-property-decorator';

@Component
export default class NavVerticalCustomer extends Vue {
  public logout(): void {
    localStorage.removeItem('programActivated');
    localStorage.removeItem('jhi-authenticationToken');
    sessionStorage.removeItem('jhi-authenticationToken');
    sessionStorage.removeItem('rol');
    this.$store.commit('logout');
    this.$router.push('/');
  }
}
