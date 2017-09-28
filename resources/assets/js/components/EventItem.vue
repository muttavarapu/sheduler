<template>
   <div>
       <td> {{title}} </td>
       <td> {{day}} </td>
       <td> {{time}} </td>
       <td> {{duration}} </td>
       <td> {{location}} </td>
       <td> <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete this user ?">
        <i class="glyphicon glyphicon-trash" ></i> Delete
    </button> </td>
    </div>
</template>


<script>
    export default {
        props: ['eventId','title','time','day','location','duration'],
        mounted() {
                console.log('event component mounted.')
        }
    }
</script>



