<template>
  <b-form @submit.prevent="submit">
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
            v-model="$v.form.image.$model"
            :state="validateState('image')"
            placeholder="Chọn hoặc kéo thả ảnh vào đây..."
            drop-placeholder="Thả ảnh vào đây..."
            browse-text="Chọn"
            accept=".jpg"
          ></b-form-file>
          <b-form-invalid-feedback>Hình ảnh không hợp lệ</b-form-invalid-feedback>
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
        <span v-if="!pending">Tạo mới</span>
        <span v-else><b-spinner small></b-spinner> Xử lý...</span>
      </b-button>
    </b-form-group>
  </b-form>
</template>

<script lang="ts">
  import { Component, mixins, Vue } from 'nuxt-property-decorator';
  import { createValidation, getValidateState, validationMixin } from '@/plugin/validation';
  import { focusEditor } from '@/plugin/editor';

  @Component({
    name: 'component-dashboard-form-create-shop-event',
    validations: createValidation('title', 'image', 'content'),
  })
  export default class extends mixins(validationMixin) {
    private form: App.Form.Create.Shop.Event = {
      title: null,
      image: null,
      content: null,
    };
    private pending: boolean = false;

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
        await this.$axios.post('/api/admin/event', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });

        this.$nuxt.$bvToast.toast('Đã tạo mới sự kiện.', {
          title: 'Tạo mới thành công!',
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
