<?php 
class Med_Form_globalevent extends Med_Form_event
{
	public function start_form()
	{		
		// get parent form
		parent::start_form();
		 $this->removeElement('heading_Client_Participation_starts_tags');
		 $this->removeElement('emip_emp_contact_name');
		 $this->removeElement('emip_emp_title');
		 $this->removeElement('emip_emp_buss_unit');
		 $this->removeElement('emip_emp_buss_unit_add_id');
		 $this->removeElement('emip_emp_email');
		 $this->removeElement('emip_emp_phone');
		 $this->removeElement('emip_event_type');
		 $this->removeElement('emip_event_type_add_id');
		 $this->removeElement('emip_event_tier');
		 $this->removeElement('emip_event_tier_add_id');
		 $this->removeElement('emip_primary_event_objective');
		 $this->removeElement('emip_primary_event_objective_add_id');
		 $this->removeElement('emip_campaign_alignment');
		 $this->removeElement('emip_campaign_alignment_add_id');
		 $this->removeElement('emip_customer_target');
		 $this->removeElement('emip_customer_target_add_id');
		 $this->removeElement('eg_geo_id');
		 $this->removeElement('eg_geo_id_add_id');
		 $this->removeElement('emip_business_unit');
		 $this->removeElement('emip_business_unit_add_id');
		 $this->removeElement('emip_sector_industries');
		 $this->removeElement('emip_sector_industries_add_id');
		 $this->removeElement('client_participation_td_starts');
		 $this->removeElement('heading_Proposed_section');
		 $this->removeElement('emip_contracted');
		 $this->removeElement('emip_sponsorship_level_cost');
		 $this->removeElement('emip_proposed_booth_space');
		 $this->removeElement('emip_branding_opportunities');
		 $this->removeElement('emip_speaking_opportunities');
		 $this->removeElement('emip_client_speaker');
		 $this->removeElement('emip_key_message');
		 $this->removeElement('emip_demo_plan');
		 $this->removeElement('emip_partner_participation');
		 $this->removeElement('end_client_participation_block');
		 $this->removeElement('heading_cost_starts_tags');
		 $this->removeElement('emip_booth_space');
		 $this->removeElement('emip_sponsorships');
		 $this->removeElement('emip_marketing_opportunities');
		 $this->removeElement('emip_venue_costs');
		 $this->removeElement('emip_production');
		 $this->removeElement('emip_housing_transportation_air');
		 $this->removeElement('emip_food_beverage');
		 $this->removeElement('emip_external_speakers');
		 $this->removeElement('emip_experience_design_costs');
		 $this->removeElement('emip_audience_generation_costs');
		 $this->removeElement('emip_collateral_costs');
		 $this->removeElement('cost_info_td_starts');
		 $this->removeElement('heading_KPI_section');
		 $this->removeElement('emf_number_of_leads');
		 $this->removeElement('emf_number_of_staff');
		 $this->removeElement('end_cost_block');
	}
}
?>