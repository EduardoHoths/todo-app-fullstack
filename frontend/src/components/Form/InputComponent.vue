<template>
  <div>
    <label :for="id">{{ label }}</label>
    <input :type="type" :placeholder="placeholder" :id="id" :value="modelValue" @input="updateValue" />
  </div>
</template>

<script lang="ts">
export default {
  name: "InputComponent",
  props: ["type", "placeholder", "id", "label", "modelValue"],
  methods: {
    updateValue(event: any) {
      this.$emit("update:modelValue", event.target.value);
    },
  },
};
</script>
