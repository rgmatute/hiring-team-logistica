import { Component, Inject, Vue } from 'vue-property-decorator';
import NavVerticalAdmin from '../sidebar/navVerticalAdmin.vue';
import NavVerticalCustomer from '../sidebar/navVerticalCustomer.vue';
import {Store} from "vuex";

@Component({
  components: {
    NavVerticalAdmin,
    NavVerticalCustomer
  }
})
export default class Menu extends Vue {
  public show = false;

  public logout(): void {
    localStorage.removeItem('jhi-authenticationToken');
    sessionStorage.removeItem('jhi-authenticationToken');
    sessionStorage.removeItem('rol');
    this.$store.commit('logout');
    this.$router.push('/');
  }

  public get username(): string {
    return this.$store.getters.account?.login ?? '';
  }

  public isAuthority(authorities: any): boolean {
    if (typeof authorities === 'string') {
      authorities = [authorities];
    }

    let response = false;
    authorities.forEach(element => {
      if (this.userAuthorities.includes(element)) {
        response = true;
      }
    });
    return response;
  }

  public get userAuthorities(): any {
    return this.$store.getters.account.authorities;
  }
}
