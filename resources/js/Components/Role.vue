<script setup>
defineProps({
    role: Number,
});

const getRoleName = (role) => {
    let roleName = "";
    switch (role) {
        case 0:
            roleName = "Agent";
            break;
        case 1:
            roleName = "AAD";
            break;
        case 2:
            roleName = "AD";
            break;
    }
    return roleName;
};
</script>

<template>
    {{ getRoleName(role) }}
</template>
