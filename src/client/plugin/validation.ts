import { email, integer, maxLength, maxValue, minLength, minValue, required, sameAs } from 'vuelidate/lib/validators';

export { validationMixin } from 'vuelidate';

let maxBirthday = new Date();
maxBirthday.setFullYear(maxBirthday.getFullYear() - 1);

let validations: { [name: string]: any } = {
  username: {
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
  },
  birthday: {
    required: required,
    // maxValue: maxValue(maxBirthday),
  },
  gender: {
    required: required,
    integer: integer,
    minValue: minValue(0),
    maxValue: maxValue(1),
  },
  phone: {
    required: required,
    maxLength: maxLength(15),
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
