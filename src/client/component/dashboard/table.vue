<template>
  <div>
    <div class="mb-2">
      <b-button size="sm" :to="`${$route.path}/create`" variant="primary">Thêm mới</b-button>
      <!-- <b-button size="sm" :href="`${$route.path}/nhap.php`">Nhập dữ liệu</b-button> -->
      <!-- <b-button size="sm" :href="`${$route.path}/xuat.php`" v-if="items.length > 0">Xuất dữ liệu</b-button> -->
    </div>

    <b-form v-if="items.length > 0">
      <b-row>
        <b-col md="6">
          <b-form-group label="Sắp xếp" label-size="sm" label-for="sortBySelect">
            <b-row no-gutters>
              <b-col xl="8" class="pr-xl-1 mb-2 mb-xl-0">
                <b-input-group size="sm">
                  <template v-slot:prepend>
                    <b-input-group-text class="group-icon">
                      <fa :icon="['fas', 'sort-amount-down-alt']"></fa>
                    </b-input-group-text>
                  </template>
                  <b-form-select v-model="sortBy" id="sortBySelect" size="sm" :options="options" class="w-75">
                    <template v-slot:first>
                      <option value="">-- Không sắp xếp --</option>
                    </template>
                  </b-form-select>
                </b-input-group>
              </b-col>
              <b-col xl="4">
                <b-input-group size="sm">
                  <template v-slot:prepend>
                    <b-input-group-text class="group-icon">
                      <fa :icon="['fas', 'random']"></fa>
                    </b-input-group-text>
                  </template>
                  <b-form-select v-model="sortDesc" size="sm" :disabled="!sortBy">
                    <option :value="false">Tăng dần</option>
                    <option :value="true">Giảm dần</option>
                  </b-form-select>
                </b-input-group>
              </b-col>
            </b-row>
          </b-form-group>
        </b-col>
        <b-col md="6">
          <b-form-group label="Phân trang" label-size="sm" label-for="perPageSelect">
            <b-row no-gutters>
              <b-col xl="4" class="pr-xl-1 mb-2 mb-xl-0">
                <b-input-group size="sm">
                  <template v-slot:prepend>
                    <b-input-group-text class="group-icon">
                      <fa :icon="['fas', 'list-ol']"></fa>
                    </b-input-group-text>
                  </template>
                  <b-form-select v-model="perPage" id="perPageSelect" size="sm" :options="perPageOptions"></b-form-select>
                </b-input-group>
              </b-col>
              <b-col xl="8">
                <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" align="fill" size="sm" class="my-0">
                  <template v-slot:first-text>
                    <fa :icon="['fas', 'angle-double-left']"></fa>
                  </template>
                  <template v-slot:prev-text>
                    <fa :icon="['fas', 'angle-left']"></fa>
                  </template>
                  <template v-slot:next-text>
                    <fa :icon="['fas', 'angle-right']"></fa>
                  </template>
                  <template v-slot:last-text>
                    <fa :icon="['fas', 'angle-double-right']"></fa>
                  </template>
                </b-pagination>
              </b-col>
            </b-row>
          </b-form-group>
        </b-col>
      </b-row>

      <b-form-group label="Tìm kiếm" label-size="sm" label-for="filterInput">
        <b-input-group size="sm">
          <template v-slot:prepend>
            <b-input-group-text class="group-icon">
              <fa :icon="['fas', 'search']"></fa>
            </b-input-group-text>
          </template>
          <b-form-input v-model="filter" id="filterInput"></b-form-input>
          <b-input-group-append>
            <b-button :disabled="!filter" @click="filter = null" class="group-icon">
              <fa :icon="['fas', 'times']"></fa>
            </b-button>
          </b-input-group-append>
        </b-input-group>
      </b-form-group>
    </b-form>

    <div v-if="items.length > 0">
      <div class="mb-3" v-if="notes">
        <label class="small">Chú thích</label>
        <div class="d-flex align-items-center">
          <div class="rounded border border py-1 px-2 mr-2 small" :class="note.class" v-for="note in notes" :key="note.bg">
            {{ note.label }}
          </div>
        </div>
      </div>
    </div>

    <p class="mb-3 small">Đang hiển thị từ {{ currentPage * perPage - perPage + 1 }} đến {{ currentPage * perPage > totalRows ? totalRows : currentPage * perPage }} trong tổng số {{ totalRows }} dòng.</p>

    <b-table
      bordered
      head-variant="light"
      show-empty
      small
      stacked="md"
      :items="items"
      :fields="fields"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filter"
      :filterIncludedFields="filterOn"
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      @filtered="onFiltered"
      :tbody-tr-class="createRowClass"
      empty-filtered-text="Không tìm thấy dữ liệu"
      label-sort-asc="Nhấn vào đây để sắp xếp tăng dần"
      label-sort-desc="Nhấn vào đây để sắp xếp giảm dần"
      label-sort-clear="Nhấn vào đây để xóa sắp xếp"
      empty-text="Không có dữ liệu"
    >
      <template v-slot:cell(actions)="row">
        <b-button size="sm" @click="info(row.item, row.index, $event.target)">
          <fa :icon="['fas', 'code']"></fa>
        </b-button>
        <b-button size="sm" @click="row.toggleDetails">
          <fa :icon="['fas', row.detailsShowing ? 'eye-slash' : 'eye']"></fa>
        </b-button>
        <b-button size="sm" :to="`${$route.path}/${row.item.id}/edit`" variant="primary">
          <fa :icon="['fas', 'edit']"></fa>
        </b-button>
        <b-button size="sm" @click="deleteRow(row.item.id)" variant="danger">
          <fa :icon="['fas', 'trash']"></fa>
        </b-button>
      </template>

      <template v-slot:row-details="row">
        <b-card>
          <ul>
            <div v-for="(value, key) in row.item" :key="key">
              <li v-if="key[0] != '_' && getLabel(key) != null">
                <b>{{ getLabel(key) }}:</b> {{ getFormatter(key) ? getFormatter(key)(value) : value }}
              </li>
            </div>
          </ul>
        </b-card>
      </template>
    </b-table>

    <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" align="fill" size="sm" v-if="items.length > 0">
      <template v-slot:first-text>
        <fa :icon="['fas', 'angle-double-left']"></fa>
      </template>
      <template v-slot:prev-text>
        <fa :icon="['fas', 'angle-left']"></fa>
      </template>
      <template v-slot:next-text>
        <fa :icon="['fas', 'angle-right']"></fa>
      </template>
      <template v-slot:last-text>
        <fa :icon="['fas', 'angle-double-right']"></fa>
      </template>
    </b-pagination>

    <b-modal :id="infoModal.id" :title="infoModal.title" ok-only @hide="resetInfoModal" size="xl">
      <pre class="mb-0">{{ infoModal.content }}</pre>
    </b-modal>
  </div>
</template>

<script lang="ts">
  import { Component, Prop, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-dashboard-table',
  })
  export default class extends Vue {
    @Prop({ type: Array, required: true })
    private items!: object[];

    @Prop({ type: Array, required: true })
    private fields!: Table.Field[];

    @Prop({ type: Array, required: true })
    private notes!: Table.Note[];

    @Prop({ type: Function, required: true })
    private rowClass!: (item: object) => string;

    private totalRows: number = 0;
    private currentPage: number = 1;
    private perPage: number = 10;
    private perPageOptions: { text: string; value: number }[] = [
      { text: '5 dòng', value: 5 },
      { text: '10 dòng', value: 10 },
      { text: '50 dòng', value: 50 },
      { text: '100 dòng', value: 100 },
    ];
    private sortBy: string = '';
    private sortDesc: boolean = false;
    private filter: string | null = null;
    private filterOn: string[] = [];
    private infoModal: { id: string; title: string; content: string } = {
      id: 'info-modal',
      title: '',
      content: '',
    };

    public fetch() {
      this.totalRows = this.items.length;
    }

    public createRowClass(item: object, type: string) {
      if (item && type == 'row') {
        return this.rowClass(item);
      }
    }

    public info(item: object, index: number, button: HTMLButtonElement) {
      let json = { ...item };
      for (let key in json) {
        if (key[0] == '_') {
          delete (<any>json)[key];
        }
      }
      this.infoModal.title = 'Dữ liệu JSON';
      this.infoModal.content = JSON.stringify(json, null, 2);
      this.$root.$emit('bv::show::modal', this.infoModal.id, button);
    }

    public resetInfoModal() {
      this.infoModal.title = '';
      this.infoModal.content = '';
    }

    public onFiltered(filteredItems: object[]) {
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    }

    public getLabel(key: string) {
      let fields = this.fields.filter((field) => field.key == key);
      return fields.length ? fields[0].label : null;
    }

    public getFormatter(key: string) {
      let fields = this.fields.filter((field) => field.key == key);
      return fields.length ? fields[0].formatter : null;
    }

    public deleteRow(id: number) {
      this.$bvModal
        .msgBoxConfirm('Bạn có chắc muốn xoá?', {
          title: 'Xác nhận',
          size: 'sm',
          buttonSize: 'sm',
          okVariant: 'danger',
          okTitle: 'Có, hãy xoá',
          cancelTitle: 'Không',
          footerClass: 'p-2',
          hideHeaderClose: false,
          centered: true,
        })
        .then((confirm) => {
          if (confirm) {
            window.location.replace(`${this.$route.path}/${id}/delete`);
          }
        });
    }

    public get options() {
      return this.fields.filter((field) => field.sortable).map((field) => ({ text: field.label, value: field.key }));
    }
  }
</script>

<style lang="scss">
  @media (min-width: 768px) {
    .table td.fit,
    .table th.fit {
      white-space: nowrap;
      width: 0.3rem;
    }
  }
</style>
