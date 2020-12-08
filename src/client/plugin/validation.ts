import { decimal, email, helpers, integer, maxLength, maxValue, minLength, minValue, required, sameAs } from 'vuelidate/lib/validators';

export { validationMixin } from 'vuelidate';

let maxBirthday = new Date();
maxBirthday.setFullYear(maxBirthday.getFullYear() - 1);

let boolean = (value: any) => typeof value == 'boolean';

let validations: { [name: string]: any } = {
  username: {
    required: required,
    minLength: minLength(4),
    maxLength: maxLength(100),
    regex: (value: any) => helpers.regex(value, /^(?=.{4,50}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/),
  },
  oldPassword: {
    required: required,
    minLength: minLength(4),
    maxLength: maxLength(100),
  },
  password: {
    required: required,
    minLength: minLength(4),
    maxLength: maxLength(100),
  },
  repassword: {
    required: required,
    minLength: minLength(4),
    maxLength: maxLength(100),
    sameAsPassword: sameAs('password'),
  },
  email: {
    required: required,
    email: email,
    maxLength: maxLength(100),
  },
  fullName: {
    required: required,
    maxLength: maxLength(100),
    regex: (value: any) =>
      helpers.regex(
        value,
        /^[a-zA-ZàáãạảăắằẳẵặâấầẩẫậèéẹẻẽêềếểễệđìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳỵỷỹýÀÁÃẠẢĂẮẰẲẴẶÂẤẦẨẪẬÈÉẸẺẼÊỀẾỂỄỆĐÌÍĨỈỊÒÓÕỌỎÔỐỒỔỖỘƠỚỜỞỠỢÙÚŨỤỦƯỨỪỬỮỰỲỴỶỸÝ]+( [a-zA-ZàáãạảăắằẳẵặâấầẩẫậèéẹẻẽêềếểễệđìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳỵỷỹýÀÁÃẠẢĂẮẰẲẴẶÂẤẦẨẪẬÈÉẸẺẼÊỀẾỂỄỆĐÌÍĨỈỊÒÓÕỌỎÔỐỒỔỖỘƠỚỜỞỠỢÙÚŨỤỦƯỨỪỬỮỰỲỴỶỸÝ]+)*$/
      ),
  },
  birthday: {
    required: required,
    regex: (value: any) => helpers.regex(value, /^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/),
    maxValue: (value: any) => new Date(value) <= maxBirthday,
  },
  gender: {
    required: required,
    boolean: boolean,
  },
  phone: {
    required: required,
    maxLength: maxLength(15),
    minLength: minLength(10),
    regex: (value: any) => helpers.regex(value, /^(\+?\d)+$/),
  },
  address: {
    required: required,
    maxLength: maxLength(500),
  },
  state: {
    required: required,
    boolean: boolean,
  },
  idRole: {
    required: required,
    integer: integer,
    minValue: minValue(1),
  },
  idAccount: {
    required: required,
    integer: integer,
    minValue: minValue(1),
  },
  title: {
    required: required,
    minLength: minLength(1),
    maxLength: maxLength(100),
  },
  content: {
    required: required,
    minLength: (value: any) => {
      let wrapper = document.createElement('div');
      wrapper.innerHTML = value;
      return (wrapper.textContent || wrapper.innerText || '').length > 0;
    },
  },
  image: {
    required: required,
  },
  image1: {
    required: required,
  },
  image2: {
    required: required,
  },
  image3: {
    required: required,
  },
  name: {
    required: required,
    minLength: minLength(1),
    maxLength: maxLength(100),
  },
  idCategoryGroup: {
    required: required,
    integer: integer,
    minValue: minValue(1),
  },
  idCategory: {
    required: required,
    integer: integer,
    minValue: minValue(1),
  },
  idBrand: {
    required: required,
    integer: integer,
    minValue: minValue(1),
  },
  price: {
    required: required,
    decimal: decimal,
    minValue: minValue(0),
  },
  quantity: {
    required: required,
    integer: integer,
    minValue: minValue(1),
  },
  star: {
    required: required,
    integer: integer,
    minValue: minValue(1),
    maxValue: maxValue(5),
  },
};

export function createValidation(...names: string[]) {
  let form: { [name: string]: any } = {};
  for (let name of names) {
    form[name] = validations[name];
  }
  return { form };
}

export function getValidateState(vue: Vue, name: string) {
  let validate = vue.$v.form[name];
  return validate!.$dirty ? !validate!.$error : null;
}

export function resetForm(vue: Vue) {
  for (let key in vue.$data.form) {
    vue.$data.form[key] = null;
  }

  vue.$nextTick(() => vue.$v.$reset());
}
