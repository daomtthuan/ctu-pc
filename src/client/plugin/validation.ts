import { email, helpers, maxLength, minLength, required, sameAs } from 'vuelidate/lib/validators';

export { validationMixin } from 'vuelidate';

let maxBirthday = new Date();
maxBirthday.setFullYear(maxBirthday.getFullYear() - 1);

let validations: { [name: string]: any } = {
  username: {
    required: required,
    minLength: minLength(4),
    maxLength: maxLength(100),
    regex: (value: any) => helpers.regex(value, /^(?=.{4,50}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/),
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
    boolean: (value: any) => typeof value == 'boolean',
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
};

export function createValidation(...names: string[]) {
  let form: { [name: string]: any } = {};
  for (let name of names) {
    form[name] = validations[name];
  }
  return { form };
}
