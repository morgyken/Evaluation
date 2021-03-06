<?php

namespace Ignite\Evaluation\Database\Seeders;

use Faker\Factory;
use Ignite\Evaluation\Entities\ProcedureCategories;
use Ignite\Evaluation\Entities\Procedures;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProceduresTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
          $procedure_categories = [
          1 => ['name' => 'Consultation', 'applies_to' => 1],
          2 => ['name' => 'Haematology', 'applies_to' => 3],
          3 => ['name' => 'Clinical Chemistry - Biochemistry', 'applies_to' => 2],
          4 => ['name' => 'Clinical Chemistry - Special & Immunochemistry', 'applies_to' => 3],
          5 => ['name' => 'Serology', 'applies_to' => 4],
          6 => ['name' => 'Parasitology & Microbiology', 'applies_to' => 6],
          7 => ['name' => 'Cytology / Histology', 'applies_to' => 3],
          8 => ['name' => 'Fluids Routine', 'applies_to' => 4],
          9 => ['name' => 'X-Ray Scans', 'applies_to' => 1],
          10 => ['name' => 'PhysioTherapy', 'applies_to' => 1],
          11 => ['name' => 'Ultrasound', 'applies_to' => 3],
          12 => ['name' => 'urina', 'applies_to' => 5],
          13 => ['name' => 'Shoulder', 'applies_to' => 6],
          14 => ['name' => 'Diagnostics', 'applies_to' => 7],
          15 => ['name' => 'Theatre', 'applies_to' => 8],
          ]; */
        $procedures = [
            ['name' => 'Consultation', 'code' => 'CONS', 'precharge' => '1', 'cash_charge' => '3000.00'],
            ['name' => 'TBC(Total Blood Count) or FBC(Full Blood Count){Hb,RBC,PCV,MCV,MCH,MCHC, WBC,PLT,}', 'code' => 'C0044', 'cash_charge' => '1000.00'],
            ['name' => 'Hb(Haemoglobin)', 'code' => 'H0069', 'cash_charge' => '400.00'],
            ['name' => 'PCV(Packed Cell Volume)', 'code' => 'P0029', 'cash_charge' => '450.00'],
            ['name' => ' WBC(White Blood Cell)Total &Differential Count', 'code' => 'W0006', 'cash_charge' => '450.00'],
            ['name' => 'Platelet Count', 'code' => 'P0063', 'cash_charge' => '450.00'],
            ['name' => 'ESR(Erythrocyte Sedimentation Rate)(Westergren S Method)', 'code' => 'E0038', 'cash_charge' => '270.00'],
            ['name' => 'PBF(Peripheral Blood Film)', 'code' => 'P0032', 'cash_charge' => '800.00'],
            ['name' => 'Malaria Parasite by Thick & Thin', 'code' => 'M0006', 'cash_charge' => '450.00'],
            ['name' => 'Malaria Parasite by QBC(Quantitative Buffy Coat)', 'code' => 'M0008', 'cash_charge' => '800.00'],
            ['name' => 'Malaria Antigen', 'code' => 'M0010', 'cash_charge' => '1000.00'],
            ['name' => 'Blood Group', 'code' => 'B0046', 'cash_charge' => '425.00'],
            ['name' => 'Reticulocytes Count', 'code' => 'R0016_M', 'cash_charge' => '500.00'],
            ['name' => 'Sickling Test', 'code' => 'S0022', 'cash_charge' => '525.00'],
            ['name' => 'L E (Lupus Erythematosis)Cells', 'code' => 'L0018', 'cash_charge' => '700.00'],
            ['name' => 'Coagulation Profile{Bleeding Time,Clotting Time,PT/INR,APTT,Platelet}', 'code' => 'D0023', 'cash_charge' => '2750.00'],
            ['name' => 'APTT(Activated Partial Thromboplastin Time)', 'code' => 'A0471', 'cash_charge' => '850.00'],
            ['name' => 'PT(Prothrombin Time)/INR(International Normalized Ratio)', 'code' => 'P0110', 'cash_charge' => '700.00'],
            ['name' => 'Bone Marrow{Procedure & Reporting}', 'code' => 'B0055', 'cash_charge' => '4500.00'],
            ['name' => 'Bone Marrow{Reporting}', 'code' => '', 'cash_charge' => '2500.00'],
            ['name' => 'CD4/CD8', 'code' => 'C0054_L', 'cash_charge' => '2750.00'],
            ['name' => 'HbA1c(Glycated Haemoglobin)', 'code' => 'H0018', 'cash_charge' => '1650.00'],
            ['name' => 'Glucose Fasting Blood  & Urine', 'code' => 'G0027_FPU', 'cash_charge' => '450.00'],
            ['name' => 'Glucose Random Blood', 'code' => 'G0027R', 'cash_charge' => '450.00'],
            ['name' => 'Glucose Post Prandial Blood & Urine', 'code' => 'G0027_PPU', 'cash_charge' => '450.00'],
            ['name' => 'GTT(Glucose Tolerance Test )with 75gms Glucose{F,1/2hr,1hr,11/2hr,2hr}Blood & Urine', 'code' => 'G8023', 'cash_charge' => '1700.00'],
            ['name' => 'Modified Glucose Tolerance Test with 100gms{1hr,2hr,3hr}Blood & Urine', 'code' => 'G8024', 'cash_charge' => '1200.00'],
            ['name' => 'LipidProfile(Cholesterol,Triglyceride,HDL,LDL,VLDL,Ratio)', 'code' => 'L0071', 'cash_charge' => '1650.00'],
            ['name' => 'Cholesterol', 'code' => 'C0106', 'cash_charge' => '600.00'],
            ['name' => 'Triglyceride', 'code' => 'T0106', 'cash_charge' => '600.00'],
            ['name' => 'HDL(High Density Lipoproteins)', 'code' => 'H0057', 'cash_charge' => '600.00'],
            ['name' => 'Renal Function Test or Kidney Function Test{Urea,Creatinine & Electrolytes}', 'code' => 'R8033', 'cash_charge' => '2000.00'],
            ['name' => 'Urea', 'code' => 'U0003', 'cash_charge' => '400.00'],
            ['name' => 'Creatinine', 'code' => 'C0169', 'cash_charge' => '450.00'],
            ['name' => 'Electrolytes{Sodium,Pottasium,Chloride}', 'code' => 'E0021', 'cash_charge' => '1000.00'],
            ['name' => 'Uric Acid', 'code' => 'U0007', 'cash_charge' => '450.00'],
            ['name' => 'Calcium', 'code' => 'C0017', 'cash_charge' => '490.00'],
            ['name' => 'Phosphate', 'code' => 'P0053', 'cash_charge' => '490.00'],
            ['name' => 'Magnesium', 'code' => 'M0002', 'cash_charge' => '550.00'],
            ['name' => 'LFT(Liver Function Tests){Bilirubin,ALP,SGOT,SGPT,GGT}', 'code' => 'L0080', 'cash_charge' => '2600.00'],
            ['name' => 'Bilirubin Estimation(Total Bilirubin,Direct Bilirubin & Indirect Bilirubin', 'code' => 'B0038', 'cash_charge' => '990.00'],
            ['name' => 'ALP(Alkaline Phosphatase)', 'code' => 'A0135', 'cash_charge' => '550.00'],
            ['name' => 'SGOT/AST(Serum Glutamic-Oxaloacetic Transaminase)', 'code' => 'S0018', 'cash_charge' => '550.00'],
            ['name' => 'SGPT/ALT(Serum Glutamic-Pyruvic Transaminase)', 'code' => 'S0019', 'cash_charge' => '550.00'],
            ['name' => 'GGT(Gamma Glutamyl Transpeptidase)', 'code' => 'G0020', 'cash_charge' => '550.00'],
            ['name' => 'Proteins(Blood){Total Protein,Albumin & Globulin)', 'code' => 'P0101', 'cash_charge' => '950.00'],
            ['name' => 'Albumin(Blood)', 'code' => 'A0125', 'cash_charge' => '750.00'],
            ['name' => 'Amylase', 'code' => 'A0432', 'cash_charge' => '950.00'],
            ['name' => 'Lipase', 'code' => 'L0068', 'cash_charge' => '1150.00'],
            ['name' => 'Cardiac Enzyme(CPK,LDH,SGOT)', 'code' => 'C0034', 'cash_charge' => '1900.00'],
            ['name' => 'CPK(Creatinine Phosphokinase)', 'code' => 'C0165', 'cash_charge' => '750.00'],
            ['name' => 'LDH(Lactate Dehydrogenase )', 'code' => 'L0012', 'cash_charge' => '700.00'],
            ['name' => 'CK-MB(Creatine Kinase-MB)', 'code' => 'C0124', 'cash_charge' => '2000.00'],
            ['name' => 'CRP(C-reacitve Protein)', 'code' => 'C0170', 'cash_charge' => '1300.00'],
            ['name' => 'hs-CRP(High-sensitive C-reactive Protein)', 'code' => 'H0265', 'cash_charge' => '2200.00'],
            ['name' => 'Iron', 'code' => 'I0282', 'cash_charge' => '1000.00'],
            ['name' => 'TIBC', 'code' => 'T0070', 'cash_charge' => '2000.00'],
            ['name' => 'Transferrin Saturation/Iron Studies{Transferrin & Iron}', 'code' => '?I0286', 'cash_charge' => '4500.00'],
            ['name' => 'Cholinesterase {Pseudo}', 'code' => 'P0113', 'cash_charge' => '1500.00'],
            ['name' => 'Protein Urine 24 hrs', 'code' => 'P0102', 'cash_charge' => '1800.00'],
            ['name' => 'ACR (Albumin Creatinine Ration)Urine', 'code' => 'A0127', 'cash_charge' => '1600.00'],
            ['name' => 'Creatinine Urine 24 hrs', 'code' => 'C0167', 'cash_charge' => '1000.00'],
            ['name' => 'Creatinine Clearance 24 hrs ', 'code' => 'C0166', 'cash_charge' => '1500.00'],
            ['name' => '(TFT)Thyroid Function Test', 'code' => 'T0066', 'cash_charge' => '3500.00'],
            ['name' => 'FT3(Free Triiodothronine)', 'code' => 'T0028', 'cash_charge' => '1200.00'],
            ['name' => 'FT4(Free Thyroxine)', 'code' => 'T0030', 'cash_charge' => '1200.00'],
            ['name' => 'TSH(Thyroid Stimulating Hormone)', 'code' => 'T0130', 'cash_charge' => '1200.00'],
            ['name' => 'FSH(Follicle-stimulating Hormone)', 'code' => 'F0058', 'cash_charge' => '2000.00'],
            ['name' => 'LH(Luteinizing Hormone)', 'code' => 'L0066', 'cash_charge' => '2000.00'],
            ['name' => 'Estradiol', 'code' => 'E0004', 'cash_charge' => '2000.00'],
            ['name' => 'Prolactin', 'code' => 'P0090', 'cash_charge' => '2000.00'],
            ['name' => 'Progesterone', 'code' => 'P0089', 'cash_charge' => '2250.00'],
            ['name' => 'Testosterone', 'code' => 'T0042', 'cash_charge' => '2250.00'],
            ['name' => 'Beta HCG(Human Chorionic Gonadotropin)', 'code' => 'H0043', 'cash_charge' => '2350.00'],
            ['name' => 'Insulin ', 'code' => 'I0275', 'cash_charge' => '2550.00'],
            ['name' => 'Cortisol ', 'code' => 'C0157', 'cash_charge' => '2200.00'],
            ['name' => 'PTH(Parathyroid Hormone)', 'code' => 'P0114', 'cash_charge' => '3500.00'],
            ['name' => 'Vitamin D(25-Hydroxyvitamin D)', 'code' => 'V0015', 'cash_charge' => '3900.00'],
            ['name' => 'D-Dimer', 'code' => 'D0002', 'cash_charge' => '2850.00'],
            ['name' => 'Troponin -I', 'code' => 'T0128', 'cash_charge' => '3100.00'],
            ['name' => 'Vitamin B12', 'code' => 'V0010', 'cash_charge' => '2050.00'],
            ['name' => 'Ferritin', 'code' => 'F0018', 'cash_charge' => '2100.00'],
            ['name' => 'Folate', 'code' => 'F0046', 'cash_charge' => '2100.00'],
            ['name' => 'HIV(Human Immunodeficiency Virus)(4th Generation)', 'code' => 'H0211', 'cash_charge' => '1390.00'],
            ['name' => 'HIV I & II Anitbodies -Spot', 'code' => 'H8036', 'cash_charge' => '500.00'],
            ['name' => 'Hepatitis A IgG', 'code' => 'H0015', 'cash_charge' => '2200.00'],
            ['name' => 'Hepatitis A IgM', 'code' => 'H0016', 'cash_charge' => '2200.00'],
            ['name' => 'HBsAG(Hepatitis B Surface Antigen)', 'code' => 'H0040', 'cash_charge' => '2250.00'],
            ['name' => 'HBsAG(Hepatitis B Surface Antigen) Spot', 'code' => 'H8037', 'cash_charge' => '800.00'],
            ['name' => 'HBsAB(Hepatitis B Surface Antibody)', 'code' => 'H0029', 'cash_charge' => '2250.00'],
            ['name' => 'HCV(Hepatitis C Virus )Antibody', 'code' => 'H0055', 'cash_charge' => '2100.00'],
            ['name' => 'HCV(Hepatitis C Virus )Antibody', 'code' => 'H8038', 'cash_charge' => '1000.00'],
            ['name' => 'AFP(Alpha Feto Protein)', 'code' => 'A0119', 'cash_charge' => '2250.00'],
            ['name' => 'CA-125(Cancer Antigen or Carbohydrate Antigen-125 )', 'code' => 'C0005', 'cash_charge' => '2350.00'],
            ['name' => 'CA 19-9(Cancer Antigen or Carbohydrate Antigen 19-9)', 'code' => 'C0007', 'cash_charge' => '2350.00'],
            ['name' => 'CEA(Carcinoembryonic Antigen)', 'code' => 'C0078', 'cash_charge' => '1900.00'],
            ['name' => 'CA 15-3(Cancer Antigen 15-3', 'code' => 'C0006', 'cash_charge' => '2350.00'],
            ['name' => 'TPSA(Total Prostate-specific antigen)', 'code' => 'P0112', 'cash_charge' => '2300.00'],
            ['name' => 'Procalcitonin', 'code' => 'P0088', 'cash_charge' => '5000.00'],
            ['name' => 'ASOT(Anti-Streptolysin O Test)', 'code' => 'A0485', 'cash_charge' => '1000.00'],
            ['name' => 'Rheumatoid Factor', 'code' => 'R0001', 'cash_charge' => '850.00'],
            ['name' => 'Helicobacter Pylori Antibody Blood', 'code' => 'H0066', 'cash_charge' => '2200.00'],
            ['name' => 'Helicobacter Pylori Antibody Stool', 'code' => 'H0063', 'cash_charge' => '3500.00'],
            ['name' => 'Salmonella Antigen Stool', 'code' => 'S8035_K', 'cash_charge' => '1500.00'],
            ['name' => 'Rota-Adeno Virus Stool', 'code' => 'R0028', 'cash_charge' => '1550.00'],
            ['name' => 'Pregnancy test Urine', 'code' => 'P0084', 'cash_charge' => '600.00'],
            ['name' => 'VDRL(Venereal Diesease Research Lab)', 'code' => 'V0003', 'cash_charge' => '580.00'],
            ['name' => 'TPHA(Treponema Pallidum Particle Agglutination)', 'code' => 'T0097', 'cash_charge' => '1300.00'],
            ['name' => 'Brucella Test', 'code' => 'B0063', 'cash_charge' => '1300.00'],
            ['name' => 'Weil Felix', 'code' => 'W0010', 'cash_charge' => '1500.00'],
            ['name' => 'Widal Test', 'code' => 'W0011', 'cash_charge' => '1000.00'],
            ['name' => 'Schistosomiasis', 'code' => 'S8038', 'cash_charge' => '1400.00'],
            ['name' => 'Bilharzia IgG', 'code' => 'B8051', 'cash_charge' => '3200.00'],
            ['name' => 'Bilharzia IgM', 'code' => '?B8052', 'cash_charge' => '3200.00'],
            ['name' => 'Bilharzia IgA', 'code' => '?B8053', 'cash_charge' => '3200.00'],
            ['name' => 'Cryptococcal Antigen Blood', 'code' => '?C0173', 'cash_charge' => '1900.00'],
            ['name' => 'Drug of Abuse Urine {Amphetamine, cocaine, Cannabinoids, Opiates, Benzodiazepine }', 'code' => 'D0045', 'cash_charge' => '5000.00'],
            ['name' => 'Amphetamine', 'code' => 'D0429', 'cash_charge' => '2000.00'],
            ['name' => 'Cocaine', 'code' => 'C0148', 'cash_charge' => '2000.00'],
            ['name' => 'Cannabinoids', 'code' => 'C0029', 'cash_charge' => '2000.00'],
            ['name' => 'Opiates', 'code' => 'O0005', 'cash_charge' => '2000.00'],
            ['name' => 'Benzodiazepine', 'code' => 'B0015', 'cash_charge' => '2000.00'],
            ['name' => 'Mantoux Test', 'code' => 'M0015', 'cash_charge' => '520.00'],
            ['name' => 'KOH Routine{Fungal Elements}', 'code' => 'F0074', 'cash_charge' => '700.00'],
            ['name' => 'Urine Routine', 'code' => 'R0041', 'cash_charge' => '490.00'],
            ['name' => 'Urine  Culture and Sensitivity', 'code' => 'C0202', 'cash_charge' => '1500.00'],
            ['name' => 'Stool Routine', 'code' => 'R0029', 'cash_charge' => '450.00'],
            ['name' => 'Stool Occult Blood', 'code' => 'O0002', 'cash_charge' => '300.00'],
            ['name' => 'Stool  Culture and Sensitivity', 'code' => 'C0197', 'cash_charge' => '1500.00'],
            ['name' => 'Semenalysis', 'code' => 'R0038', 'cash_charge' => '1600.00'],
            ['name' => 'Semen Culture and Sensitivity', 'code' => 'C0195', 'cash_charge' => '1500.00'],
            ['name' => 'Gram Stain', 'code' => 'G0047', 'cash_charge' => '550.00'],
            ['name' => 'AFB(Acid Fast Bacilli)or ZN(Ziehl-Neelsen) Stain-Single sample', 'code' => 'A0109', 'cash_charge' => '490.00'],
            ['name' => 'AFB(Acid Fast Bacilli)or ZN(Ziehl-Neelsen) Stain-Three samples', 'code' => 'A0111', 'cash_charge' => '1400.00'],
            ['name' => 'CSF Culture and Sensitivity', 'code' => 'C0189', 'cash_charge' => '1500.00'],
            ['name' => 'Fluid Culture and Sensitivity (Pleural,Ascitic,Peritoneal etc', 'code' => 'C0185', 'cash_charge' => '1500.00'],
            ['name' => 'Sputum Routine {Gram,AFB/ZN}', 'code' => 'R0039', 'cash_charge' => '1000.00'],
            ['name' => 'Sputum Culture and Sensitivity', 'code' => 'C0196', 'cash_charge' => '1500.00'],
            ['name' => 'Blood Culture and Sensitivity', 'code' => 'C0182', 'cash_charge' => '1800.00'],
            ['name' => 'HVS  Swab  Routine Culture and Sensitivity ', 'code' => 'C0203', 'cash_charge' => '1500.00'],
            ['name' => 'Pus Swab  Routine Culture and Sensitivity ', 'code' => 'C0193', 'cash_charge' => '1500.00'],
            ['name' => 'Nasal/Respiratory Swab  Routine Culture and Sensitivity ', 'code' => 'C0194', 'cash_charge' => '1500.00'],
            ['name' => 'Ear Swab  Routine Culture and Sensitivity ', 'code' => 'C0190', 'cash_charge' => '1500.00'],
            ['name' => 'Eye Swab  Routine Culture and Sensitivity ', 'code' => 'C0191', 'cash_charge' => '1500.00'],
            ['name' => 'Throat Swab  Routine Culture and Sensitivity ', 'code' => 'C0198', 'cash_charge' => '1500.00'],
            ['name' => 'Urethral Swab /Prostate Massage Routine Culture and Sensitivity ', 'code' => 'C0201', 'cash_charge' => '1500.00'],
            ['name' => 'Auxillary,Groin,Anal,Rectal /Aerobic Bacteria  Routine Culture and Sensitivity ', 'code' => 'C0192', 'cash_charge' => '1500.00'],
            ['name' => 'FNA(Fine Needle Aspiration){Procedure & Reporting}-Breast ', 'code' => 'F0035', 'cash_charge' => '2500.00'],
            ['name' => 'FNA(Fine Needle Aspiration){Procedure & Reporting}-Lymphnode', 'code' => 'F0037', 'cash_charge' => '2500.00'],
            ['name' => 'FNA(Fine Needle Aspiration){Procedure & Reporting}-Other Organ', 'code' => 'F0039', 'cash_charge' => '2500.00'],
            ['name' => 'FNA(Fine Needle Aspiration){Procedure & Reporting}-Thyroid', 'code' => 'F0041', 'cash_charge' => '2500.00'],
            ['name' => 'FNA(Fine Needle Aspiration){Procedure & Reporting}-Second Openion', 'code' => 'F0096', 'cash_charge' => '2500.00'],
            ['name' => 'Cytology-CSF', 'code' => 'C0228', 'cash_charge' => '1800.00'],
            ['name' => 'Cytology-Drain Fluid', 'code' => 'C0229', 'cash_charge' => '1800.00'],
            ['name' => 'Cytology- Nipple Discharge', 'code' => 'C0230', 'cash_charge' => '1800.00'],
            ['name' => 'Cytology-Ascitic Fluid', 'code' => 'C226', 'cash_charge' => '1800.00'],
            ['name' => 'Cytology-Fluids/Scrappping', 'code' => 'C0233', 'cash_charge' => '1800.00'],
            ['name' => 'Cytology-Pericardial Fluid', 'code' => 'C0234', 'cash_charge' => '1800.00'],
            ['name' => 'Cytology-Peritoneal Washing', 'code' => 'C0235', 'cash_charge' => '1800.00'],
            ['name' => 'Cytology-Pleuaral Fluid', 'code' => 'C0236', 'cash_charge' => '1800.00'],
            ['name' => 'Cytology-Sputum', 'code' => 'C0238', 'cash_charge' => '1800.00'],
            ['name' => 'Cytology-Synovial Fluid', 'code' => 'C0239', 'cash_charge' => '1800.00'],
            ['name' => 'Histology Small', 'code' => 'H0192', 'cash_charge' => '3300.00'],
            ['name' => 'Histology Medium', 'code' => 'H0191', 'cash_charge' => '5500.00'],
            ['name' => 'Histology Large', 'code' => 'H0189', 'cash_charge' => '8000.00'],
            ['name' => 'Pap Conventiontional{ Reporting}', 'code' => 'P0011', 'cash_charge' => '1450.00'],
            ['name' => 'Pap Conventiontional{Procedure}', 'code' => 'PAP SMEAR PROCEDURE CHARGES', 'cash_charge' => '350.00'],
            ['name' => 'Fluid-USG/CT (Guided) Collection Procedure ', 'code' => 'F044', 'cash_charge' => '7500.00'],
            ['name' => 'Fluid-USG/CT (Without) Collection Procedure', 'code' => 'FNAC PROCEDURE CHARGES', 'cash_charge' => '2500.00'],
            ['name' => 'CSF Routine Examination(Cell Count,Glucose,LDH,Protein,Gram, ZN,Indian Ink) ', 'code' => 'R0033', 'cash_charge' => '3950.00'],
            ['name' => 'Fluid Routine Examination(Cell Count,Glucose,LDH,Protein,Gram,ZN)', 'code' => 'R0031', 'cash_charge' => '3500.00'],
            ['name' => 'Fluid/CSF Cell Count ', 'code' => 'C0080', 'cash_charge' => '600.00'],
            ['name' => 'Fluid/CSF Glucose', 'code' => 'G0028', 'cash_charge' => '450.00'],
            ['name' => 'Ascitic Fluid LDH ', 'code' => 'L0013', 'cash_charge' => '825.00'],
            ['name' => 'Peritoneal Fluid LDH', 'code' => 'L0014', 'cash_charge' => '825.00'],
            ['name' => 'Pleural Fluid LDH ', 'code' => 'L0015', 'cash_charge' => '825.00'],
            ['name' => 'CSF Protein ', 'code' => 'P0104', 'cash_charge' => '500.00'],
            ['name' => 'Ascitic Protein', 'code' => 'P0103', 'cash_charge' => '500.00'],
            ['name' => 'Pedicardial Protein', 'code' => 'P0105', 'cash_charge' => '500.00'],
            ['name' => 'Pleural Protein', 'code' => 'P0106', 'cash_charge' => '500.00'],
            ['name' => 'Synovial Protein', 'code' => 'P0107', 'cash_charge' => '500.00'],
            ['name' => 'CSF Cryptococcal Antigen ', 'code' => '?C0172', 'cash_charge' => '1600.00'],
            ['name' => 'CSF Indian Ink Preparation ', 'code' => 'I0267', 'cash_charge' => '625.00'],
            ['name' => 'Upper ABD Scan', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'Consultation - Review', 'code' => 'CONS', 'cash_charge' => '2500.00'],
            ['name' => 'Skull-2 Views', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Pituitary Fossa', 'code' => '', 'cash_charge' => '900.00'],
            ['name' => 'Mandible', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Facial Bones', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'T.M.J  Views', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'Mastoidds 3 Views', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Para Nasal Sinuses-Om', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Orbits 2 - Views', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Nasal Bone', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Post Nasal Space', 'code' => '', 'cash_charge' => '900.00'],
            ['name' => 'Cervical Spine (Neck AP/LAT)', 'code' => '', 'cash_charge' => '1700.00'],
            ['name' => 'Upper ABD Scan', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'Sacrum & Coccyx', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Chest -PA', 'code' => '', 'cash_charge' => '900.00'],
            ['name' => 'Chest AP/LAT or OBLQ 2 VIEWS', 'code' => '', 'cash_charge' => '1700.00'],
            ['name' => 'Ribs 2 Views OBLQ Alone', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Thoracic Inlet AP/LAT/THORACIC Inlet', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Sterno-Clavicular Joint', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Sternum', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Abdomen', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Abdomen Supine & Erect ( 2Views)', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Pelvimetry(ELP)', 'code' => '', 'cash_charge' => '3200.00'],
            ['name' => 'Hands/Fingers AP/LAT', 'code' => '', 'cash_charge' => '900.00'],
            ['name' => 'Both Hands AP/LAT', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Wrist AP/LAT', 'code' => '', 'cash_charge' => '900.00'],
            ['name' => 'Both  Wrist AP/LAT', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Wrist Scaphoid Views', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Forearm', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Both Foe arms AP/LAT', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'Elbow', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Both Elbow AP/LAT', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Humerus AP/LAT', 'code' => '', 'cash_charge' => '900.00'],
            ['name' => 'Both Humeri AP/LAT', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Shoulder AP/LAT', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Both Shouders AP/LAT', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'Bone Age AP/LAT', 'code' => '', 'cash_charge' => '3200.00'],
            ['name' => 'Bone AG- WRIST/hand', 'code' => '', 'cash_charge' => '3200.00'],
            ['name' => 'Clavicle', 'code' => '', 'cash_charge' => '900.00'],
            ['name' => 'PhysioTherapy', 'code' => 'PHYSIO', 'cash_charge' => '2500.00'],
            ['name' => 'Upper ABD Scan', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'Lower ABD Scan', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'Obstetric Ultrasound', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'Upper & Lower ABD Scan', 'code' => '', 'cash_charge' => '4200.00'],
            ['name' => 'Scrotal Scan', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'Scrotal Scan including color doppler', 'code' => '', 'cash_charge' => '4200.00'],
            ['name' => 'Thyroid scan', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'thyroid scan with doppler', 'code' => '', 'cash_charge' => '4200.00'],
            ['name' => 'Full Obstetrics', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'Follicular Tracking', 'code' => '', 'cash_charge' => '4200.00'],
            ['name' => 'Pelvic Scan', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'Doppler of Limb', 'code' => '', 'cash_charge' => '4200.00'],
            ['name' => 'Doppler of Bilateral Limbs', 'code' => '', 'cash_charge' => '6400.00'],
            ['name' => 'Cranial  U/S', 'code' => '', 'cash_charge' => '3200.00'],
            ['name' => 'Skull 2 views', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Pituitary Fossa', 'code' => '', 'cash_charge' => '900.00'],
            ['name' => 'Mandible', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Facial Bones', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'TMI 4 Views', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'Mastoids 3 Views', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Para nasa', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'TMI 4 Views', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'Para nasal sinuses-OM', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Orbits 2 Views', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Nasal Bone', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Post Nasal Space', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Cervical Spine(Neck AP/LAT)', 'code' => '', 'cash_charge' => '1700.00'],
            ['name' => 'Extension/Flexion 2 Views', 'code' => '', 'cash_charge' => '1900.00'],
            ['name' => 'Cervical Spine -5 views(Odontoid Process)', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'Thoracic Spine', 'code' => '', 'cash_charge' => '1800.00'],
            ['name' => 'Lumbo-Sacral Spine', 'code' => '', 'cash_charge' => '1800.00'],
            ['name' => 'Sacrum & Coccyx', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Chest - PA', 'code' => '', 'cash_charge' => '900.00'],
            ['name' => 'Chest AP/LAT or OBLQ 2 views', 'code' => '', 'cash_charge' => '1700.00'],
            ['name' => 'Ribs 2-views OBLQ Alone', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Sterno-Clavicular Joint', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Sternum', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Abdomen', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Abdomen Supine & Erect(2 views)', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Pelvimetry(ELP)', 'code' => '', 'cash_charge' => '3200.00'],
            ['name' => 'Hands/Fingers AP/LAT', 'code' => '', 'cash_charge' => '900.00'],
            ['name' => 'Both Hands', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Both Hands AP/LAT', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Wrist AP/LAT', 'code' => '', 'cash_charge' => '900.00'],
            ['name' => 'Both Wrist AP/LAT', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Wrist-Scaphoid Views', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Forearm', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Both Forearm AP/LAT', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'Elbow', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Both Elbow AP/LAT', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Humerus AP/LAT', 'code' => '', 'cash_charge' => '900.00'],
            ['name' => 'Both Humeri AP/LAT', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Shoulder AP/LAT', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Both Shoulders AP/LAT', 'code' => '', 'cash_charge' => '2100.00'],
            ['name' => 'Bone Age-AP Wrist/Hand', 'code' => '', 'cash_charge' => '3200.00'],
            ['name' => 'Clavicle', 'code' => '', 'cash_charge' => '900.00'],
            ['name' => 'Both Clavicles', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Scapula', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Lower Limb', 'code' => '', 'cash_charge' => '1000.00'],
            ['name' => 'Foot/Toes AP/LAT', 'code' => '', 'cash_charge' => '1000.00'],
            ['name' => 'Ankle AP/LAT', 'code' => '', 'cash_charge' => '1000.00'],
            ['name' => 'Leg(Tabia/Fibula)', 'code' => '', 'cash_charge' => '1200.00'],
            ['name' => 'Knee AP/LAT', 'code' => '', 'cash_charge' => '1100.00'],
            ['name' => 'Knee AP/LAT/SKYLINE', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'Pelvis', 'code' => '', 'cash_charge' => '1200.00'],
            ['name' => 'Hip AP/LAT', 'code' => '', 'cash_charge' => '1200.00'],
            ['name' => 'Femur AP/LAT', 'code' => '', 'cash_charge' => '1200.00'],
            ['name' => 'Calcaneum - Lateral', 'code' => '', 'cash_charge' => '1000.00'],
            ['name' => 'Pelvis AP & 2 OBLQS', 'code' => '', 'cash_charge' => '1600.00'],
            ['name' => 'ANA (Antinuclear antibody screening(End point titre)', 'code' => 'A0437', 'cash_charge' => '2350.00'],
            ['name' => 'TSH	', 'code' => 'T0130', 'cash_charge' => '730.00'],
            ['name' => 'PROTEIN ELECTROPHORESIS(SERUM)', 'code' => 'P0096', 'cash_charge' => '1980.00'],
            ['name' => 'LFT', 'code' => 'L0080', 'cash_charge' => '2000.00'],
            ['name' => 'Renal Function Test', 'code' => 'R8033', 'cash_charge' => '845.00'],
            ['name' => 'RENAL FUNCTION TEST', 'code' => 'R8033', 'cash_charge' => '2000.00'],
            ['name' => 'Renal Function Test', 'code' => 'R3088', 'cash_charge' => '1700.00'],
            ['name' => 'THYROID FUNCTION TEST', 'code' => 'T0066', 'cash_charge' => '3500.00'],
            ['name' => 'THYROID FUNCTION TEST', 'code' => 'T0066', 'cash_charge' => '3500.00'],
            ['name' => 'Both Knees X-ray', 'code' => '', 'cash_charge' => '2200.00'],
            ['name' => 'MRI Lumbar spine', 'code' => '', 'cash_charge' => '15500.00'],
            ['name' => 'C3 Complement-3(Serum)	', 'code' => 'C0003', 'cash_charge' => '1400.00'],
            ['name' => 'C3 Complement-3(Serum)	', 'code' => 'C0003', 'cash_charge' => '1400.00'],
            ['name' => 'C4 Complement-4(Serum)	', 'code' => 'C0004', 'cash_charge' => '1400.00'],
            ['name' => 'C4 Complement-4(Serum)	', 'code' => 'C0004', 'cash_charge' => '1400.00'],
            ['name' => 'C3 Complement-3(Serum)	', 'code' => 'C0003', 'cash_charge' => '1400.00'],
            ['name' => 'Aldolase Enzymatic(serum)', 'code' => 'A0131', 'cash_charge' => '2200.00'],
            ['name' => 'Aldolase Enzymatic(serum)', 'code' => 'A0131', 'cash_charge' => '2200.00'],
            ['name' => 'CCP Antibody Cyclic Citrullinated Peptide(Serum)	', 'code' => 'C0047	', 'cash_charge' => '2750.00'],
            ['name' => 'Shoulder', 'code' => '', 'cash_charge' => '1000.00'],
            ['name' => 'Shoulder', 'code' => '', 'cash_charge' => '1000.00'],
            ['name' => 'Shoulder', 'code' => '', 'cash_charge' => '1000.00'],
            ['name' => 'Shoulder', 'code' => '', 'cash_charge' => '1000.00'],
            ['name' => 'ESR', 'code' => '12', 'cash_charge' => '250.00'],
            ['name' => 'ESR', 'code' => '12', 'cash_charge' => '250.00'],
            ['name' => 'ESR', 'code' => '12', 'cash_charge' => '250.00'],
            ['name' => 'Culture and sensitivity urine', 'code' => 'C0202', 'cash_charge' => '1500.00'],
            ['name' => 'Cholesterol-Total (Serum)	', 'code' => 'c0106', 'cash_charge' => '600.00'],
            ['name' => 'AMH Mullerian Inhibiting Substance(Serum)	', 'code' => 'A0417	', 'cash_charge' => '5000.00'],
            ['name' => 'Culture and sensitivity urine', 'code' => 'C0202', 'cash_charge' => '1500.00'],
            ['name' => 'Culture and sensitivity urine', 'code' => 'C0202', 'cash_charge' => '1500.00'],
            ['name' => 'ESR Automated(Blood)	', 'code' => 'E0038', 'cash_charge' => '270.00'],
            ['name' => 'ANA by IFA Anti Nuclear Antibody screening(End point titre)	', 'code' => 'A0437', 'cash_charge' => '2350.00'],
            ['name' => 'FT4 [Free thyroxine],', 'code' => 'T0030', 'cash_charge' => '1100.00'],
            ['name' => 'FT3 [Free Triiodothrine],],', 'code' => 'T0028', 'cash_charge' => '1200.00'],
            ['name' => 'GENE EXPERT MTB/IRF', 'code' => 'A0017', 'cash_charge' => '6000.00'],
            ['name' => 'AFB [ZN], Stain', 'code' => 'A0109', 'cash_charge' => '490.00'],
            ['name' => 'Gram stain', 'code' => 'G0047', 'cash_charge' => '490.00'],
            ['name' => 'AFB - XPERT PANEL', 'code' => 'AO117', 'cash_charge' => '5000.00'],
            ['name' => 'Gram stain ', 'code' => 'G0047', 'cash_charge' => '550.00'],
            ['name' => 'Gram stain ', 'code' => 'G0047', 'cash_charge' => '550.00'],
            ['name' => 'WIDAL TEST ', 'code' => 'W0011', 'cash_charge' => '1000.00'],
            ['name' => 'VMA Vanillyl Mandellic Acid [Urine24H],', 'code' => 'V0020', 'cash_charge' => '8500.00'],
            ['name' => 'Helicobacter Pylori IgG antibodies (serum)', 'code' => 'H0066', 'cash_charge' => '2200.00'],
            ['name' => 'Histology small', 'code' => 'H0192', 'cash_charge' => '3300.00'],
            ['name' => 'Histology small [H00192],', 'code' => 'H0192', 'cash_charge' => '3300.00'],
            ['name' => 'Histology smal', 'code' => 'H0192', 'cash_charge' => '3300.00'],
            ['name' => 'Lipase', 'code' => 'L0068', 'cash_charge' => '1150.00'],
            ['name' => 'Chlamydia Trachomatis PCR (Vaginal swab)', 'code' => 'C0094', 'cash_charge' => '9500.00'],
            ['name' => 'POTASSIUM  (K+)', 'code' => 'P0094', 'cash_charge' => '425.00'],
            ['name' => 'Pleural Fluid : Biochemistry/Microscopy,', 'code' => '', 'cash_charge' => '2615.00'],
            ['name' => 'D-DIMER ', 'code' => 'D0002', 'cash_charge' => '2850.00'],
            ['name' => 'D-DIMER ', 'code' => 'D0002', 'cash_charge' => '2850.00'],
            ['name' => 'QUANTIFFERON MTB GOLD', 'code' => '', 'cash_charge' => '6100.00'],
            ['name' => 'VITAMIN E', 'code' => 'V0018', 'cash_charge' => '5625.00'],
            ['name' => 'DRUG OF ABUSE', 'code' => 'DOO45', 'cash_charge' => '5000.00'],
            ['name' => 'DRUG OF ABUSE', 'code' => 'DOO45', 'cash_charge' => '5000.00'],
            ['name' => 'TESTOSTERONE', 'code' => '', 'cash_charge' => '2250.00'],
            ['name' => 'CORTISOL', 'code' => '', 'cash_charge' => '2250.00'],
            ['name' => 'CORTISOL', 'code' => '', 'cash_charge' => '2250.00'],
            ['name' => 'CMV PCR ', 'code' => 'C0134', 'cash_charge' => '9900.00'],
            ['name' => 'VARICCELLA PCR ', 'code' => 'V0025', 'cash_charge' => '6750.00'],
            ['name' => 'HSV PCR', 'code' => 'H00271', 'cash_charge' => '7750.00'],
            ['name' => 'HIV VIRAL LOAD', 'code' => 'H00797', 'cash_charge' => '7500.00'],
            ['name' => 'Protein electrophoresis(serum)', 'code' => 'P0096', 'cash_charge' => '1980.00'],
            ['name' => 'Protein electrophoresis(serum)', 'code' => 'P0096', 'cash_charge' => '1980.00'],
            ['name' => 'Urine  routine', 'code' => 'R0041', 'cash_charge' => '280.00'],
            ['name' => 'Urine  routine', 'code' => 'R0041', 'cash_charge' => '280.00'],
            ['name' => 'BENCE JONES PROTEINS ', 'code' => 'B0013', 'cash_charge' => '3000.00'],
            ['name' => 'BETA - 2 -MICROGLOBULIN (Serum)', 'code' => 'B0031', 'cash_charge' => '2800.00'],
            ['name' => 'Surgery', 'code' => 'DSAFDAS45', 'cash_charge' => '330.00']
        ];

        $procedure_categories = [
            1 => ['name' => 'Doctor', 'applies_to' => 1],
            2 => ['name' => 'Evaluation', 'applies_to' => 1],
            3 => ['name' => 'Pharmacy', 'applies_to' => 2],
            4 => ['name' => 'Lab', 'applies_to' => 3],
            5 => ['name' => 'Radiology', 'applies_to' => 4],
            6 => ['name' => 'Nursing', 'applies_to' => 5],
            7 => ['name' => 'UltraSound', 'applies_to' => 6],
            8 => ['name' => 'Diagnostics', 'applies_to' => 7],
            9 => ['name' => 'Theatre', 'applies_to' => 8],
            10 => ['name' => 'Physiotherapy', 'applies_to' => 9],
            11 => ['name' => 'Dental', 'applies_to' => 10],
            12 => ['name' => 'Optical', 'applies_to' => 11],
            13 => ['name' => 'inpatient', 'applies_to' => 9],
        ];

        DB::transaction(function () use ($procedure_categories, $procedures) {
            //$sample = config('procedures.categories');
            $faker = Factory::create();
            foreach ($procedure_categories as $category) {
                $runner = new ProcedureCategories;
                $runner->name = $category['name'];
                $runner->applies_to = $category['applies_to'];
                $runner->save();
            }
            foreach ($procedures as $procedure) {
                $p = new Procedures;
                $p->name = $procedure['name'];
                $p->code = $procedure['code'];
                if (isset($procedure['precharge'])) {
                    $p->precharge = $procedure['precharge'];
                }
                $p->category = $faker->randomElement(array_keys($procedure_categories));
                $p->cash_charge = $procedure['cash_charge'];
                $p->insurance_charge = $procedure['cash_charge'] + mt_rand(1, $procedure['cash_charge']);
                $p->charge_insurance = $faker->randomElement([true, false]);
                if (!empty($p->code)) {
                    $p->save();
                }
            }
        });
    }

}
