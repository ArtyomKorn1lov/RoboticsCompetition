import { getProgramItems } from "./api/program";
import { sendRegisterForm, searchCountries } from "./api/events";
import Helper from "./template/helper";
import getFilteredPhrases from "./loc";
import * as Constants from './constants';
import * as DocsEnum from "./enums/docs";

import Timing from "./models/program/Timing";
import Program from "./models/program";
import MediaPopup from "./models/media";
import FormFieldValue from "./models/field/FormFieldValue";
import FormField from "./models/field/FormField";
import FormGroup from "./models/field/FormGroup";
import FormFields from "./models/field";
import FormSearch from "./models/field/FormSearch";

export default {
    getProgramItems,
    sendRegisterForm,
    searchCountries,
    TemplateHelper: new Helper(),
    getFilteredPhrases,
    Constants,
    DocsEnum,
    Program,
    Timing,
    MediaPopup,
    FormFieldValue,
    FormField,
    FormGroup,
    FormFields,
    FormSearch
};