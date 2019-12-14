# if "$dir"/commit; then
  dir_tag=$dir_git/refs/tags/backup

  if [[ ! -d $dir_tag ]]; then
    num=0

  else
    num=$(ls -t "$dir_tag" | head -1)
  fi

  dir_backup=backup
  tag_name=$dir_backup/$((++num))
  tag_path=$dir_worktrees/$dir_backup
  tag_path_full=$dir_worktrees/$tag_name
  echo "New tag: $tag_name"

  git tag "$tag_name"
  git worktree add "$tag_path_full" "$tag_name"
  ln --symbolic --force --relative "$tag_path_full" "$tag_path"/latest
  git reset --hard "$branch_dev"
  git push --force-with-lease --tags
# fi
