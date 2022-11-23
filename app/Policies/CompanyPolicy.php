<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $authCompany = Auth::user()->company()->first();
        return $user->is_super || $user->hasPermission('companies.index');
    }

    public function viewAnycompany(User $user)
    {
        $authCompany = Auth::user()->company()->first();
        return $user->is_super || $user->hasPermission('company.index');
    }

    public function viewAnycompanys(User $user)
    {
        $authCompany = Auth::user()->company()->first();
        return $user->is_super ;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Company $company
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->is_super || $user->hasPermission('companies.show');
    }
    

    public function viewcompany(User $user)
    {
        return ($user->is_super || $user->hasPermission('company.show'));
    }

    
    public function viewcompanys(User $user)
    {
        return $user->is_super;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_super || $user->hasPermission('companies.create');
    }

    public function createcompany(User $user)
    {
        return $user->is_super || $user->hasPermission('company.create');
    }

    public function createcompanys(User $user)
    {
        return $user->is_super;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Company $company
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->is_super || $user->hasPermission('companies.update');
    }

    public function updatecompany(User $user)
    {
        return $user->is_super || $user->hasPermission('company.update');
    }

    public function updatecompanys(User $user)
    {
        return $user->is_super;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Company $company
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->is_super || $user->hasPermission('companies.destroy');
    }

    public function deletecompany(User $user)
    {
        return $user->is_super || $user->hasPermission('company.destroy');
    }

    public function deletecompanys(User $user)
    {
        return $user->is_super;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Company $company
     * @return mixed
     */
    public function restore(User $user, Company $company)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Company $company
     * @return mixed
     */
    public function forceDelete(User $user, Company $company)
    {
        //
    }

    /**
     * @param User $user
     * @param Company $company
     * @return bool
     */
    public function CompanyRoles(User $user, Company $company)
    {

        return $user->is_super || ($user->is_owner && $user->isMemberOf($company) || $user->is_admin);
    }

    /**
     * @param User $user
     * @param Company $company
     * @return bool
     */
    public function companyModulesPermissions(User $user, Company $company)
    {
        return $user->is_super || ($user->is_owner && $user->isMemberOf($company) || $user->is_admin);
    }

    /**
     * @param User $user
     * @param Company $company
     * @return bool
     */
    public function allowCompanyModulesPermission(User $user, Company $company)
    {
        return $user->is_super || ($user->is_owner && $user->isMemberOf($company) || $user->is_admin);
    }

    /**
     * @param User $user
     * @param Company $company
     * @return bool
     */
    public function userCreate(User $user, Company $company)
    {
        return $user->is_super || ($user->is_owner && $user->isMemberOf($company)) || ($user->role->slug == 'manager' && $user->isMemberOf($company) || $user->is_admin);
    }

    /**
     * @param User $user
     * @param Company $company
     * @return bool
     */
    public function userStore(User $user, Company $company): bool
    {
        return $user->is_super || ($user->is_owner && $user->isMemberOf($company) || $user->is_admin);
    }

    /**
     * @param User $user
     * @param Company $company
     * @return bool
     */
    public function addRole(User $user, Company $company)
    {
        return $user->is_super || ($user->is_owner && $user->isMemberOf($company) || $user->is_admin);
    }
}
