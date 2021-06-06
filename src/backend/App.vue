<template>
  <div>
    <h1>Testimonials Slider</h1>
    <div class="btns p-mt-2">
      <button @click="saveData" class="button-primary button p-mr-1">
        Save
      </button>
      <button @click="addItem" class="button">Add Item</button>
    </div>
    <div
      @click="saveSuccess = false"
      v-if="saveSuccess"
      class="notice notice-success p-py-3 p-my-3"
    >
      Data successfully saved.
    </div>
    <DataTable class="p-mt-3" dataKey="id" :value="displayedData">
      <template #empty>
        <div class="p-grid p-ai-center">
          <div class="p-mr-3">No data available.</div>
          <button @click="addItem" class="button button-primary">
            Start Adding
          </button>
        </div>
      </template>
      <Column field="review" header="Review">
        <template #body="item">
          <Textarea v-model="item.data.review" style="width: 100%"></Textarea>
        </template>
      </Column>
      <Column field="platform" sortable header="Platform">
        <template #body="item">
          <Dropdown
            v-model="item.data.platform"
            optionLabel="name"
            optionValue="value"
            :options="platformOptions"
            style="width: 80%"
          ></Dropdown>
        </template>
      </Column>
      <Column field="rating" sortable header="Rating">
        <template #body="item">
          <Rating
            style="width: 100%"
            v-model="item.data.rating"
            :cancel="false"
            :stars="5"
          ></Rating>
        </template>
      </Column>
      <Column field="date" sortable header="Date">
        <template #body="item">
          <Calendar v-model="item.data.date" dateFormat="MM yy" />
        </template>
      </Column>
      <Column header="Action">
        <template #body="item">
          <button @click="removeItem(item.data)" class="button button-danger">
            Remove
          </button>
        </template>
      </Column>
      <template #footer>
        <button @click="saveData" class="button-primary button p-mr-1">
          Save
        </button>
        <button v-if="displayedData.length > 0" @click="addItem" class="button">
          + Add Item
        </button>
      </template>
    </DataTable>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Rating from "primevue/rating";
import Textarea from "primevue/textarea";
import Dropdown from "primevue/dropdown";
import Calendar from "primevue/calendar";
import uuid from "uuid";

const platformOptions = [
  { name: "Trustpilot", value: "trustpilot" },
  { name: "ProductReview.com.au", value: "productreview" },
];

const restUrl = "/wp-json/abhinash/testimonials-slider/api";

export default {
  components: { DataTable, Column, Rating, Textarea, Dropdown, Calendar },
  setup() {
    const displayedData = ref([]);
    const saveSuccess = ref(false);

    const fetchData = () => {
      fetch(restUrl)
        .then((response) => response.json())
        .then((data) => {
          data = JSON.parse(JSON.parse(data));
          data["data"].forEach((item) => {
            displayedData.value.push(item);
          });
        });
    };

    onMounted(() => {
      fetchData();
    });

    const saveData = () => {
      fetch(restUrl, {
        method: "POST",
        headers: {
          "X-WP-Nonce": wpApiSettings.nonce,
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ data: displayedData.value }),
      }).then((response) => {
        saveSuccess.value = true;
      });
    };

    const addItem = () => {
      displayedData.value.push({
        id: uuid.v1(),
        review: "",
        platform: "",
        date: "",
        rating: 0,
      });
    };

    const removeItem = (item) => {
      console.log(item);
      displayedData.value = displayedData.value.filter(
        (value) => value.id != item.id
      );
    };

    return {
      addItem,
      saveSuccess,
      removeItem,
      saveData,
      platformOptions,
      displayedData,
    };
  },
};
</script>

<style>
</style>