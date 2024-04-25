import { Component, Inject, Vue } from 'vue-property-decorator';
import Menu from '@/core/menu/menu.vue';

@Component({
  components: {
    'menu-nav': Menu
  }
})
export default class NavbarVertical extends Vue {

}