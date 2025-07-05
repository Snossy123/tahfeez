<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openEditModal(id, start, end, total) {
  document.getElementById('edit-id').value = id;
  document.getElementById('edit-start-date').value = start;
  document.getElementById('edit-end-date').value = end;
  document.getElementById('edit-total-lessons').value = total;
  var modal = new bootstrap.Modal(document.getElementById('editSubscriptionModal'));
  modal.show();
}

function openRenewModal(id) {
  document.getElementById('renew-id').value = id;
  var modal = new bootstrap.Modal(document.getElementById('renewSubscriptionModal'));
  modal.show();
}

</script>

</body>
</html>