<template>
    <b-input
            :disabled="disabled"
            :id="metadatum.metadatum.metadata_type_object.component + '-' + metadatum.metadatum.slug"
            :value="value"
            @input="onInput($event)"
            @blur="onBlur"
            type="textarea" />
</template>

<script>
    export default {
        props: {
            metadatum: Object,
            value: [String, Number, Array],
            disabled: false
        },
        methods: {
            onInput(value) {
                this.$emit('input', value);
            },
            onBlur() {
                this.$emit('blur');
            }
        }
    }
</script>
