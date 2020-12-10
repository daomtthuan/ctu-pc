<template>
  <div>
    <b-form v-if="items.length > 0">
      <b-row>
        <b-col md="6">
          <b-form-group label="Sắp xếp" label-size="sm" label-for="select-sort">
            <b-row no-gutters>
              <b-col xl="8" class="pr-xl-1 mb-2 mb-xl-0">
                <b-form-select v-model="sortBy" id="select-sort" size="sm" :options="options">
                  <template #first>
                    <option value="">Không sắp xếp</option>
                  </template>
                </b-form-select>
              </b-col>
              <b-col xl="4">
                <b-form-select v-model="sortDesc" size="sm" :disabled="!sortBy">
                  <option :value="false">Tăng dần</option>
                  <option :value="true">Giảm dần</option>
                </b-form-select>
              </b-col>
            </b-row>
          </b-form-group>
        </b-col>
        <b-col md="6">
          <b-form-group label="Phân trang" label-size="sm" label-for="select-per-page">
            <b-row no-gutters>
              <b-col xl="4" class="pr-xl-1 mb-2 mb-xl-0">
                <b-form-select v-model="perPage" id="select-per-page" size="sm" :options="perPageOptions"></b-form-select>
              </b-col>
              <b-col xl="8">
                <b-form-input
                  size="sm"
                  readonly
                  :value="
                    `Từ ${currentPage * perPage - perPage + 1} đến ${
                      currentPage * perPage > totalRows ? totalRows : currentPage * perPage
                    } trong ${totalRows} dòng`
                  "
                ></b-form-input>
              </b-col>
            </b-row>
          </b-form-group>
        </b-col>
      </b-row>

      <b-form-group label="Tìm kiếm" label-size="sm" label-for="input-filter">
        <b-form-input type="search" v-model="filter" id="input-filter" size="sm" placeholder="Nhập dữ liệu cần tìm"></b-form-input>
      </b-form-group>
    </b-form>

    <div v-if="items.length > 0">
      <div class="mb-3" v-if="notes">
        <label class="small">Chú thích</label>
        <div class="d-flex align-items-center">
          <div class="border border py-1 px-2 mr-2 small" :class="note.class" v-for="note in notes" :key="note.bg">
            {{ note.label }}
          </div>
        </div>
      </div>
    </div>

    <h5 class="text-primary">{{ title }}</h5>

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
      <template #cell(actions)="row">
        <b-button size="sm" @click="info(row.item, row.index, $event.target)">
          <fa :icon="['fas', 'code']"></fa>
        </b-button>
        <b-button size="sm" @click="row.toggleDetails">
          <fa :icon="['fas', row.detailsShowing ? 'eye-slash' : 'eye']"></fa>
        </b-button>
        <b-button size="sm" :to="`${$route.path}/${row.item.id}/edit`" variant="primary" v-if="allowEdit">
          <fa :icon="['fas', 'edit']"></fa>
        </b-button>
        <b-button size="sm" @click="removeRow(row.item.id)" variant="danger" :disabled="removePending" v-if="allowRemove">
          <span v-if="!removePending"><fa :icon="['fas', 'trash']"></fa></span>
          <span v-else><b-spinner small></b-spinner></span>
        </b-button>
        <slot name="more-actions" :row="row"></slot>
      </template>

      <template #row-details="row">
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

    <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" align="center" v-if="items.length > 0">
      <template #first-text>
        <fa :icon="['fas', 'angle-double-left']"></fa>
      </template>
      <template #prev-text>
        <fa :icon="['fas', 'angle-left']"></fa>
      </template>
      <template #next-text>
        <fa :icon="['fas', 'angle-right']"></fa>
      </template>
      <template #last-text>
        <fa :icon="['fas', 'angle-double-right']"></fa>
      </template>
    </b-pagination>

    <b-modal :id="infoModal.id" :title="infoModal.title" ok-only @hide="resetInfoModal" size="xl">
      <b-textarea id="input-infoModal-conten" class="text-monospace" readonly rows="15" v-model="infoModal.content"></b-textarea>
    </b-modal>
  </div>
</template>

<script lang="ts">
  import { Component, Prop, Vue, Watch } from 'nuxt-property-decorator';

  @Component({
    name: 'component-dashboard-table',
  })
  export default class extends Vue {
    @Prop({ type: String, required: true })
    private title!: string;

    @Prop({ type: Array, required: true })
    private items!: object[];

    @Prop({ type: Array, required: true })
    private fields!: App.Component.Table.Field[];

    @Prop({ type: Array })
    private notes?: App.Component.Table.Note[];

    @Prop({ type: Function })
    private rowClass?: (item: object) => string;

    @Prop({ type: Function })
    private removeItem?: (id: number) => Promise<void>;

    @Prop({ type: Boolean, default: true })
    private allowEdit!: boolean;

    @Prop({ type: Boolean, default: true })
    private allowRemove!: boolean;

    private removePending: boolean = false;
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
    private infoModal: { id: string; title: string; content: string } = { id: 'info-modal', title: '', content: '' };

    public fetch() {
      this.totalRows = this.items.length;
    }

    public createRowClass(item: object, type: string) {
      if (this.rowClass) {
        if (item && type == 'row') {
          return this.rowClass(item);
        }
      }
      return null;
    }

    public info(item: object, index: number, button: HTMLButtonElement) {
      let json = { ...item };
      for (let key in json) {
        if (key[0] == '_') {
          delete (<any>json)[key];
        }
      }
      this.infoModal.title = 'Dữ liệu từ máy chủ';
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

    public async removeRow(id: number) {
      if (this.removeItem) {
        let confirm = await this.$nuxt.$bvModal.msgBoxConfirm(
          [
            this.$createElement('span', 'Bạn có chắc muốn xoá?'),
            this.$createElement('br'),
            this.$createElement('strong', 'Mọi dữ liệu liên quan cũng sẽ bị xoá theo và không thể khôi phục'),
          ],
          {
            title: 'Xác nhận thao tác',
            okVariant: 'danger',
            okTitle: 'Có, hãy xoá',
            cancelTitle: 'Không',
          }
        );

        if (confirm) {
          this.removePending = true;
          await this.removeItem(id);
          this.removePending = false;
        }
      }
    }

    public get options() {
      return this.fields.filter((field) => field.sortable).map((field) => ({ text: field.label, value: field.key }));
    }

    @Watch('items')
    public onItemsChanged(newValue: object[]) {
      if (this.filter != null && this.filter.length > 0) {
        return;
      }

      this.totalRows = this.items.length;
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
