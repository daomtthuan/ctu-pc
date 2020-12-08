<template>
  <div class="text-center" v-if="$fetchState.pending"><b-spinner small></b-spinner> Đang tải...</div>
  <b-form @submit.prevent="submit" v-else-if="!$fetchState.error">
    <b-form-group label="Trạng thái:">
      <b-form-radio-group class="py-2" v-model="$v.form.state.$model" :state="validateState('state')">
        <b-form-radio id="radio-state-enabled" :value="true">Kích hoạt</b-form-radio>
        <b-form-radio id="radio-state-disabled" :value="false">Vô hiệu hoá</b-form-radio>
      </b-form-radio-group>
      <div class="text-danger small mt-1" v-show="validateState('state') === false">Trạng thái không hợp lệ</div>
    </b-form-group>
    <b-row>
      <b-col lg="6">
        <b-form-group label="Tiêu đề:" label-for="input-title">
          <b-form-input
            id="input-title"
            type="text"
            placeholder="Nhập tiêu đề"
            autocomplete="off"
            v-model="$v.form.title.$model"
            :state="validateState('title')"
          ></b-form-input>
          <b-form-invalid-feedback>Tiêu đề không hợp lệ</b-form-invalid-feedback>
        </b-form-group>
      </b-col>
      <b-col lg="6">
        <b-form-group label="Hình ảnh:" label-for="file-image">
          <b-form-file
            id="file-image"
            v-model="form.image"
            placeholder="Chọn hoặc kéo thả ảnh vào đây..."
            drop-placeholder="Thả ảnh vào đây..."
            browse-text="Chọn"
            accept=".jpg"
          ></b-form-file>
        </b-form-group>
      </b-col>
    </b-row>

    <b-form-group>
      <label class="d-block" @click="focusContent">Nội dung:</label>
      <vue-editor id="input-content" v-model="$v.form.content.$model" :class="contentClass" placeholder="Nhập nội dung" />
      <b-form-invalid-feedback>Nội dung không hợp lệ</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group class="text-center">
      <b-button type="submit" variant="primary" :disabled="pending">
        <span v-if="!pending">Chỉnh sửa</span>
        <span v-else><b-spinner small></b-spinner> Xử lý...</span>
      </b-button>
    </b-form-group>
  </b-form>
</template>

<script lang="ts">
  import { focusEditor } from '@/plugin/editor';
  import { createValidation, getValidateState, validationMixin } from '@/plugin/validation';
  import { Component, mixins, Prop, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-dashboard-form-edit-shop-event',
    validations: createValidation('title', 'content', 'state'),
  })
  export default class extends mixins(validationMixin) {
    @Prop({ type: String, required: true })
    private id!: number;

    private form: App.Form.Edit.Shop.Event = {
      title: null,
      image: null,
      content: null,
      state: null,
    };
    private pending: boolean = false;

    public async fetch() {
      try {
        let events: Entity.Event[] = (await this.$axios.get('/api/admin/event', { params: { id: this.id } })).data;
        if (events.length == 1) {
          this.form.title = events[0].title;
          this.form.content = (await this.$axios.get(events[0].postUrl)).data;
          this.form.state = events[0].state;
        } else {
          this.$nuxt.error({ statusCode: 404 });
        }
      } catch (error) {
        let response = <Response>error.response;
        this.$nuxt.error({ statusCode: response.status });
      }
    }

    public validateState(name: string) {
      return getValidateState(this, name);
    }

    public async submit() {
      this.$v.form.$touch();
      if (this.$v.$anyError) {
        return;
      }

      try {
        this.pending = true;
        let formData = new FormData();
        formData.append('title', JSON.stringify({ data: this.form.title }));
        formData.append('image', this.form.image!);
        formData.append('content', JSON.stringify({ data: this.form.content }));
        formData.append('state', JSON.stringify({ data: this.form.state }));
        if (Boolean(this.form.image)) {
          formData.append('image', this.form.image!);
        }

        await this.$axios.put('/api/admin/event', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
          params: { id: this.id },
        });

        this.$nuxt.$bvToast.toast('Thông tin sự kiện đã được chỉnh sửa.', {
          title: 'Chỉnh sửa thành công!',
          variant: 'success',
          solid: true,
          toaster: 'b-toaster-bottom-right',
        });
        this.$router.back();
      } catch (error) {
        this.$nuxt.error({ statusCode: (<Response>error.response).status });
      } finally {
        this.pending = false;
      }
    }

    public focusContent() {
      focusEditor('input-content');
    }

    public get contentClass(): string | null {
      let state = this.validateState('content');
      return state === true ? 'is-valid' : state === false ? 'is-invalid' : null;
    }
  }
</script>

<style lang="scss">
  @import '@/asset/style/editor';
</style>
