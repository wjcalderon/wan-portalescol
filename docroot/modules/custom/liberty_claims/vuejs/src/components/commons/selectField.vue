<template>
  <div v-bind:class="{field: true, error: submited && hasError('variable')}">
    <div class="label">Ciudad</div>
    <select v-model="casualtyData.variable">
      <option v-for="item in cities" v-bind:key="item[0]" v-bind:value="item[0]">{{ item[1] }}</option>
    </select>
    <div class="error-message" v-show="submited && hasError('variable')">{{ hasError('variable') }}</div>
  </div>
</template>
<script>
import steps from '../../mixins/steps';

export default {
  mixins: [steps],
  props: ['cities'],
  data() {
    return {
      casualtyData: {
        variable: '1',
      },
      validationRules: {
        variable: {
        },
      },
    }
  },
}
</script>